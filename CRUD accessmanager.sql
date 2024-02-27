drop table permissions;
drop table menus;
drop table users;


SELECT * FROM users;
SELECT * FROM menus;
SELECT * FROM permissions;


delete from permissions where fk_idusers = 4;
DELETE from permissions where fk_idusers = 13;
DELETE  FROM menus;
DELETE  FROM users;
DELETE  FROM permissions;

SELECT m.menu from menus m 
INNER JOIN permissions p 
ON m.id = p.fk_idmenus 
INNER JOIN users u
ON u.id = p.fk_idusers
WHERE u.id != 1;

SELECT m.menu from menus m  
INNER JOIN permissions p
on m.id = p.fk_idmenus
WHERE p.fk_idusers = 1 AND p.fk_idmenus = 2;

SELECT m.menu FROM menus m
INNER JOIN permissions p
INNER JOIN users u 
ON p.fk_idusers = u.id
WHERE u.id != 1;

/* SELECT DO MENU COM BASE NO USUÁRIO  */
select m.menu, u.name from menus m
INNER JOIN permissions p
on m.id = p.fk_idmenus
INNER JOIN users u
on p.fk_idusers = u.id
WHERE u.name = 'casjunior';

select m.menu, m.link, u.name from menus m
INNER JOIN permissions p
on m.id = p.fk_idmenus
INNER JOIN users u
on p.fk_idusers = u.id
WHERE u.name = 'casjunior';

select u.id from users u 
WHERE u.name = "casjunior";

/*SELECT QUE IMPEDE O USUÁRIO ACESSAR A PÁGINA CASO NÃO TENHA ACESSO*/
select p.id from permissions p
where fk_idusers = 1 AND fk_idmenus = 7;

SELECT m.menu, m.id FROM menus m
        INNER JOIN permissions p
        on m.id = p.fk_idmenus
        where p.fk_idusers = 1;

SELECT m.menu, m.id FROM menus m
        INNER JOIN permissions p
        on m.id = p.fk_idmenus
        where p.fk_idusers = 1;
        
        /* SELECT DE MENUS QUE O USUÁRIO É ADMINISTRADOR APENAS */
        SELECT m.menu FROM menus m 
        INNER JOIN permissions p 
        ON m.id = p.fk_idmenus
        INNER JOIN users u
        ON p.fk_idusers = u.id
        WHERE p.adm = 1 AND u.name = "casjunior";
        
        SELECT adm FROM permissions p INNER JOIN users u ON p.fk_idusers = u.id WHERE u.login = "casjunior" AND p.adm = '1';
        
   
        
        
