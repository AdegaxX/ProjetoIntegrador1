SHOW VARIABLES LIKE 'secure_file_priv';

SHOW VARIABLES LIKE 'event_scheduler'; # Mostra a disponibilidade do 'event_scheduler'.


SET GLOBAL event_scheduler = ON; # ON para ligar e OFF para desligar.

show events; # Mostra os eventos criados/funcionando.
# drop event exportar_e_limpar_dados;




DELIMITER $$
CREATE EVENT exportar_e_limpar_dados
ON SCHEDULE EVERY 1 DAY
STARTS TIMESTAMPADD(SECOND, time_to_sec('21:01:00'), CURRENT_DATE)
DO
BEGIN
	# Executa apenas de domingo(0) a sexta(6):
	if weekday(now()) < 6 then
		# Salva o arquivo com o nome: ex: 'arquivo_20250118.csv' ano / mês / dia
		set @file_path = concat('C:/xampp/htdocs/formulario/SQL salvos/arquivo_', date_format(now(), '%Y%m%d'), '.csv');
		
		set @salvar = concat(
			"SELECT * INTO OUTFILE '", @file_path, "' ", 
			"FIELDS TERMINATED BY ',' ",
			"ENCLOSED BY '\"'", 
			"LINES TERMINATED BY '\n' ",
			"FROM usuarios"
		);
		
		prepare stmt from @salvar;
		execute stmt;
		deallocate prepare stmt;
    
		-- Apaga os dados e reseta os índices
		TRUNCATE TABLE usuarios;
    end if;
END $$

DELIMITER ;



use usuarios;
select * from usuarios;