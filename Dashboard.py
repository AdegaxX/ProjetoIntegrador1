import streamlit as st
import mysql.connector
import pandas as pd

# Função para conectar ao banco de dados e obter dados
def get_data():
    try:
        conn = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="usuarios2"
        )
        query = "SELECT * FROM usuarios;"
        df = pd.read_sql_query(query, conn)
        conn.close()
        return df
    except mysql.connector.Error as err:
        st.error(f"Erro ao conectar ao banco de dados: {err}")
        return pd.DataFrame()

# Função para atualizar o status no banco de dados
def update_status(nome, status):
    try:
        conn = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="usuarios2"
        )
        cursor = conn.cursor()
        query = "UPDATE usuarios SET RecebeuQuentinha = %s WHERE nome = %s"
        cursor.execute(query, (status, nome))
        conn.commit()
        conn.close()
    except mysql.connector.Error as err:
        st.error(f"Erro ao atualizar status no banco de dados: {err}")

# Função para resetar interesse de todos os alunos para 0
def reset_interesse():
    try:
        conn = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="usuarios2"
        )
        cursor = conn.cursor()
        query = "UPDATE usuarios SET interesse = 0"
        cursor.execute(query)
        conn.commit()
        conn.close()
        st.success("Interesse de todos os alunos foi atualizado para 0.")
    except mysql.connector.Error as err:
        st.error(f"Erro ao resetar interesse no banco de dados: {err}")

# Função para resetar quem recebeu as quentinhas
def reset_quentinhas():
    try:
        conn = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="usuarios2"
        )
        cursor = conn.cursor()
        query = "UPDATE usuarios SET RecebeuQuentinha = 0"
        cursor.execute(query)
        conn.commit()
        conn.close()
        st.success("Status de quentinhas foi resetado para todos os alunos.")
    except mysql.connector.Error as err:
        st.error(f"Erro ao resetar status de quentinhas no banco de dados: {err}")

st.set_page_config(layout="wide", page_title="Dashboard do RU")

# Configurar o título do dashboard
st.title("Restaurante Universitário - UFC")

# Obter dados do banco
df = get_data()
df = df.iloc[:, 1:]  # Remove a coluna de ID para visualização

# Filtrar os alunos com Interesse = 1
df_interesse = df[df['interesse'] == 1].drop(columns=['interesse'])

if not df_interesse.empty:
    if 'nome' in df_interesse.columns:
        # Inicialize o estado da sessão para o status
        if 'status_quentinha' not in st.session_state:
            st.session_state['status_quentinha'] = {
                nome: bool(recebeu) for nome, recebeu in zip(df_interesse['nome'], df_interesse['RecebeuQuentinha'])
            }

        if 'aluno_selecionado' not in st.session_state:
            st.session_state['aluno_selecionado'] = df_interesse['nome'].iloc[0]

        # Função para resetar o checkbox ao mudar o aluno
        def on_aluno_change():
            nome = st.session_state['aluno_selecionado']
            st.session_state['status_checkbox'] = st.session_state['status_quentinha'][nome]

        # Inicializar o estado do checkbox
        if 'status_checkbox' not in st.session_state:
            st.session_state['status_checkbox'] = st.session_state['status_quentinha'][st.session_state['aluno_selecionado']]

        # Layout com colunas
        col1, col2 = st.columns(2)

        with col1:
            st.subheader("Filtrar por nome")
            st.selectbox(
                "Selecione um aluno",
                df_interesse['nome'].unique(),
                index=df_interesse['nome'].tolist().index(st.session_state['aluno_selecionado']),
                key='aluno_selecionado',
                on_change=on_aluno_change
            )

            aluno_selecionado = st.session_state['aluno_selecionado']

            st.write("Detalhes do aluno:")
            st.dataframe(df_interesse[df_interesse['nome'] == aluno_selecionado], use_container_width=True)

            # Checkbox para verificar status
            status = st.checkbox(
                "O aluno recebeu a quentinha?",
                value=st.session_state['status_checkbox'],
                key='status_checkbox'
            )

            # Atualizar o estado global com o valor do checkbox e banco de dados
            if st.session_state['status_quentinha'][aluno_selecionado] != status:
                st.session_state['status_quentinha'][aluno_selecionado] = status
                update_status(aluno_selecionado, int(status))

            # Mensagem com base no status
            if status:
                st.success("Sim! Este aluno recebeu a quentinha.")
            else:
                st.info("Não. Este aluno não recebeu a quentinha.")

        with col2:
            st.subheader("Lista completa de alunos")
            st.dataframe(df_interesse, use_container_width=True)

        # Exibir métricas
        total_alunos = len(df_interesse)
        alunos_com_quentinha = sum(st.session_state['status_quentinha'].values())

        st.sidebar.header("Administração")
        st.sidebar.metric("Total de alunos", total_alunos)
        st.sidebar.metric("Alunos que receberam quentinha", alunos_com_quentinha)

        # Botões com espaçamento no final
        if st.sidebar.button("Resetar Interesse"):
            reset_interesse()

        if st.sidebar.button("Resetar Quentinhas"):
            reset_quentinhas()

else:
    st.warning("Nenhum aluno com Interesse = 1 foi encontrado.")


# streamlit run "C:\Users\rians\PycharmProjects\teste_dashboard\teste8.py"