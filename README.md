# kurssienhallinta
Ohjelmistokehittäjänä toimiminen / Projekti: Kurssienhallinta / Marko Kairinen

SELECT @next := COALESCE(MAX(opiskelijatunnus), 0) + 1 FROM opiskelijat;

SET @sql := CONCAT('ALTER TABLE opiskelijat AUTO_INCREMENT = ', @next);
PREPARE s FROM @sql; 
EXECUTE s; 
DEALLOCATE PREPARE s;


