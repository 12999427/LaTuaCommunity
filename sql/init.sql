-- Creazione del database
CREATE DATABASE IF NOT EXISTS community_elettronica DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE community_elettronica;

-- ==========================================
-- 1. TABELLE INDIPENDENTI (Entità forti)
-- ==========================================

-- Entità: produttori
CREATE TABLE produttori (
    id_produttore INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    nazione VARCHAR(50) NOT NULL,
    sito_web VARCHAR(256) DEFAULT NULL
) ENGINE=InnoDB;

-- Entità: utenti
CREATE TABLE utenti (
    id_utente INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    livello_esperienza VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

-- Entità: categoria
CREATE TABLE categoria (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descrizione TEXT NOT NULL
) ENGINE=InnoDB;

-- Entità: progetti
CREATE TABLE progetti (
    id_progetto INT AUTO_INCREMENT PRIMARY KEY,
    titolo VARCHAR(150) NOT NULL,
    descrizione_schema TEXT NOT NULL,
    difficolta VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

-- ==========================================
-- 2. TABELLA CENTRALE: componenti
-- Include le Foreign Key delle relazioni 1:N (produce, pubblica)
-- ==========================================

CREATE TABLE componenti (
    id_componente INT AUTO_INCREMENT PRIMARY KEY,
    sigla VARCHAR(50) NOT NULL,
    tensione_op_v_min DECIMAL(6,2) DEFAULT NULL, -- (0,1) in Volt, es. 3.30
    tensione_op_v_max DECIMAL(6,2) DEFAULT NULL, -- (0,1) in Volt, es. 5.00
    corrente_max_ma INT DEFAULT NULL,            -- (0,1) in mA, es. 500
    interfaccia VARCHAR(50) DEFAULT NULL,        -- (0,1) es. I2C, SPI, PWM
    package VARCHAR(40) DEFAULT NULL,            -- (0,1) es. DIP-8, TO-220
    note TEXT NOT NULL,
    link_datasheet VARCHAR(256) DEFAULT NULL,    -- (0,1) URL al PDF

    -- Relazione "produce": (1,1) lato componenti, (1,N) lato produttori
    id_produttore INT NOT NULL,
    
    -- Relazione "pubblica": (1,1) lato componenti, (0,N) lato utenti
    id_utente_pubblica INT NOT NULL,

    CONSTRAINT fk_componenti_produttori 
        FOREIGN KEY (id_produttore) REFERENCES produttori(id_produttore)
        ON DELETE RESTRICT ON UPDATE CASCADE,

    CONSTRAINT fk_componenti_utenti_pubblica 
        FOREIGN KEY (id_utente_pubblica) REFERENCES utenti(id_utente)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ==========================================
-- 3. TABELLE PONTE (Relazioni N:M)
-- ==========================================

-- Relazione "recensisce" (0,N) - (0,N) tra utenti e componenti
CREATE TABLE recensisce (
    id_recensione INT AUTO_INCREMENT PRIMARY KEY,
    id_utente INT NOT NULL,
    id_componente INT NOT NULL,
    testo TEXT NOT NULL,
    CONSTRAINT fk_recensisce_utente 
        FOREIGN KEY (id_utente) REFERENCES utenti(id_utente)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_recensisce_componente 
        FOREIGN KEY (id_componente) REFERENCES componenti(id_componente)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Relazione "appartiene" (1,N) - (1,N) tra componenti e categoria
CREATE TABLE appartiene (
    id_componente INT NOT NULL,
    id_categorie INT NOT NULL,
    PRIMARY KEY (id_componente, id_categorie),
    CONSTRAINT fk_appartiene_componente 
        FOREIGN KEY (id_componente) REFERENCES componenti(id_componente)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_appartiene_categoria 
        FOREIGN KEY (id_categorie) REFERENCES categoria(id_categorie)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Relazione "compone" (1,N) - (1,N) tra componenti e progetti
CREATE TABLE compone (
    id_componente INT NOT NULL,
    id_progetto INT NOT NULL,
    PRIMARY KEY (id_componente, id_progetto),
    CONSTRAINT fk_compone_componente 
        FOREIGN KEY (id_componente) REFERENCES componenti(id_componente)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_compone_progetto 
        FOREIGN KEY (id_progetto) REFERENCES progetti(id_progetto)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;


USE community_elettronica;

-- ==========================================
-- 1. POPOLAMENTO TABELLE INDIPENDENTI
-- ==========================================

-- Produttori
INSERT INTO produttori (id_produttore, nome, nazione, sito_web) VALUES
(1, 'STMicroelectronics', 'Italia / Francia', 'https://www.st.com'),
(2, 'Texas Instruments', 'USA', 'https://www.ti.com'),
(3, 'Espressif Systems', 'Cina', 'https://www.espressif.com'),
(4, 'Bosch Sensortec', 'Germania', 'https://www.bosch-sensortec.com'),
(5, 'Yageo', 'Taiwan', NULL);

-- Utenti (le password sono hash fittizi in stile bcrypt)
INSERT INTO utenti (id_utente, username, email, password, livello_esperienza) VALUES
(1, 'gio_dev', 'giovanni@itisrossi.vi.it', '$2y$10$abcdefghijklmnopqrstuv1234567890', 'Avanzato'),
(2, 'marco_hw', 'marco@itisrossi.vi.it', '$2y$10$abcdefghijklmnopqrstuv0987654321', 'Intermedio'),
(3, 'solder_ninja', 'ninja@maker.it', '$2y$10$zyxwvutsrqponmlkjihgfedcba123456', 'Esperto'),
(4, 'newbie_spark', 'luca@studenti.it', '$2y$10$1234567890abcdefghijklmnopqrstuv', 'Principiante');

-- Categorie
INSERT INTO categoria (id_categorie, nome, descrizione) VALUES
(1, 'Microcontrollori e SoC', 'Unità di elaborazione programmabili, SoC Wi-Fi/Bluetooth e chip logici.'),
(2, 'Driver e Potenza', 'Ponti H, regolatori di tensione lineari/switching e MOSFET di potenza.'),
(3, 'Sensori e IMU', 'Sensori ambientali, accelerometri, giroscopi e bussole digitali.'),
(4, 'Timer e Oscillatori', 'Circuiti integrati per la generazione di impulsi, PWM e segnali di clock.'),
(5, 'Componenti Passivi', 'Resistenze, condensatori, induttori e diodi standard.');

-- Progetti
INSERT INTO progetti (id_progetto, titolo, descrizione_schema, difficolta) VALUES
(1, 'Robot Calcio Autonomo Omni', 'Piattaforma mobile omnidirezionale a 4 motori con controllo integrato di orientamento tramite IMU BNO055 e gestione motori in PWM.', 'Alta'),
(2, 'Stazione Meteo Wi-Fi MQTT', 'Nodo sensore a basso consumo basato su ESP32 alimentato a batteria con invio telemetria su broker locale.', 'Media'),
(3, 'Generatore PWM da Banco 555', 'Circuito classico su millefori per testare servomotori o regolare la luminosità di strisce LED tramite potenziometro.', 'Bassa');

-- ==========================================
-- 2. POPOLAMENTO TABELLA CENTRALE: componenti
-- ==========================================

INSERT INTO componenti (
    id_componente, sigla, tensione_op_v_min, tensione_op_v_max, corrente_max_ma, 
    interfaccia, package, note, link_datasheet, id_produttore, id_utente_pubblica
) VALUES
(
    1, 'L298N', 4.50, 46.00, 2000, 
    'PWM / GPIO', 'Multiwatt15', 
    'Doppio ponte H per motori DC o passo-passo. Richiede diodi di flyback esterni (es. 1N5819 Schottky) e un dissipatore adeguato. Caduta di tensione interna elevata (~2V).', 
    'https://www.st.com/resource/en/datasheet/l298.pdf', 1, 1
),
(
    2, 'ESP32-WROOM-32E', 3.00, 3.60, 500, 
    'I2C / SPI / UART / PWM', 'SMD Modulo', 
    'I pin GPIO sono esclusivamente a 3.3V (NON sono 5V tolerant). Inserire un condensatore da 10uF-100uF tra EN e GND se ha problemi di boot automatico durante il flash.', 
    'https://www.espressif.com/sites/default/files/documentation/esp32-wroom-32e_esp32-wroom-32ue_datasheet_en.pdf', 3, 1
),
(
    3, 'NE555P', 4.50, 16.00, 200, 
    'Analogico / Impulsi', 'DIP-8', 
    'Timer universale configurabile in modalità astabile o monostabile. Collegare sempre un condensatore ceramico da 10nF sul pin 5 (CTRL) verso massa per stabilizzare la tensione di riferimento.', 
    'https://www.ti.com/lit/ds/symlink/ne555.pdf', 2, 2
),
(
    4, 'L7805CV', 7.00, 35.00, 1500, 
    NULL, 'TO-220', 
    'Regolatore lineare fisso a 5V. Richiede un condensatore da 330nF in ingresso e 100nF in uscita il più vicino possibile ai pin. Scalda parecchio se alimentato a 12V o più: montare dissipatore.', 
    'https://www.st.com/resource/en/datasheet/l78.pdf', 1, 3
),
(
    5, 'BNO055', 2.40, 3.60, 12, 
    'I2C / UART', 'LGA-28', 
    'IMU a 9 assi con fusione sensoriale integrata (restituisce direttamente angoli di Eulero e Quaternioni). Indirizzo I2C di default 0x28 (o 0x29 impostando alto il pin ADR).', 
    'https://www.bosch-sensortec.com/media/boschsensortec/downloads/datasheets/bst-bno055-ds000.pdf', 4, 1
),
(
    6, 'STM32F103C8T6', 2.00, 3.60, 150, 
    'I2C / SPI / UART / CAN', 'LQFP-48', 
    'Microcontrollore ARM Cortex-M3 a 72MHz (classico chip della scheda BluePill). Molti pin sono 5V-tolerant (indicati con FT sul pinout ufficiale). Si programma comodamente via SWD con ST-Link.', 
    'https://www.st.com/resource/en/datasheet/stm32f103c8.pdf', 1, 2
),
(
    7, 'Resistenza 10k Ohm 1/4W', NULL, 250.00, 5, 
    NULL, 'Assiale 0207', 
    'Resistenza a strato metallico tolleranza 1%. Valore standard ideale per resistenze di pull-up / pull-down su linee digitali GPIO o partitori di tensione.', 
    NULL, 5, 4
);

-- ==========================================
-- 3. POPOLAMENTO TABELLE PONTE (Relazioni N:M)
-- ==========================================

-- Relazione "appartiene" (Componente <-> Categoria)
INSERT INTO appartiene (id_componente, id_categorie) VALUES
(1, 2), -- L298N -> Driver e Potenza
(2, 1), -- ESP32 -> Microcontrollori e SoC
(3, 4), -- NE555P -> Timer e Oscillatori
(4, 2), -- L7805CV -> Driver e Potenza
(5, 3), -- BNO055 -> Sensori e IMU
(6, 1), -- STM32 -> Microcontrollori e SoC
(7, 5); -- Resistenza 10k -> Componenti Passivi

-- Relazione "compone" (Componente <-> Progetto)
INSERT INTO compone (id_componente, id_progetto) VALUES
-- Progetto 1: Robot Calcio
(1, 1), -- L298N
(4, 1), -- L7805CV
(5, 1), -- BNO055
(6, 1), -- STM32F103C8T6
(7, 1), -- Resistenza 10k
-- Progetto 2: Stazione Meteo
(2, 2), -- ESP32
(7, 2), -- Resistenza 10k
-- Progetto 3: Generatore PWM
(3, 3), -- NE555P
(4, 3), -- L7805CV
(7, 3); -- Resistenza 10k

-- Relazione "recensisce" (Utente <-> Componente)
INSERT INTO recensisce (id_utente, id_componente, testo) VALUES
(2, 1, 'Indistruttibile per iniziare, ma ormai preferisco driver MOSFET come il TB6612FNG o il BTS7960 perché l''L298N mangia quasi 2V di tensione sui motori e scalda come una stufa.'),
(3, 2, 'Ottimo modulo Wi-Fi. Attenzione solo a non usare i pin dell''ADC2 mentre il Wi-Fi è attivo perché vanno in conflitto nel firmware Espressif!'),
(1, 5, 'Il fatto che calcoli i quaternioni direttamente in hardware ti salva la vita: non devi impazzire con il filtro di Kalman sul microcontrollore.'),
(4, 4, 'Saldato al contrario la prima volta, ma per fortuna ha la protezione termica integrata ed è sopravvissuto.');