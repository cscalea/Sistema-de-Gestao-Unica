/* INSERT DOS MENUS */

INSERT INTO menus  (menu, link, class) VALUES 
('Monitoramento de Segurança', 'http://10.15.16.211/antivirus/', "fas fa-shield-alt"),
('CPP', '#', "fas fa-address-book"),  
('Programação de Trabalho', 'https://programacao.ipem.sp.gov.br/', "far fa-calendar-alt"), 
('Gestão da Fonte 4', '#' , "fas fa-dollar-sign"),  
('Ouvidoria', 'https://fiscaliza.ipem.sp.gov.br/', "fas fa-phone-volume"),
('Módulo da Qualidade', '#', "fas fa-clipboard-check"),
('Gestão de Laboratórios', '#', "fas fa-atom"),  
('Apoio à gestão de VTR', '#', "fas fa-truck"), 
('Módulo do RH', 'addPermission.php', "far fa-address-card"),  
('Boletim de Tráfego', '#', "far fa-file-alt"),
('Helpdesk', 'https://chamados.ipem.sp.gov.br/', "far fa-keyboard"),  
('Gestão do Patrimônio', '#', "fas fa-tag"), 
('Ferramenta de BI', '#', "fas fa-chart-bar")
;

INSERT INTO permissions (fk_idusers, fk_idmenus, adm) VALUES
(9, 1, 1),
(9, 2, 1),
(9, 3, 1),
(9, 4, 1),
(9, 5, 1),
(9, 6, 1),
(9, 7, 1),
(9, 8, 1),
(9, 9, 1)
;


