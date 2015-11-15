CREATE DATABASE MONOPOLY;

USE MONOPOLY;

CREATE TABLE USERS 
(
  ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  LOGIN VARCHAR(32) NOT NULL UNIQUE,
  PASSWORD VARCHAR(128) NOT NULL,
  NAME VARCHAR(64) NOT NULL,
  EMAIL VARCHAR(64) NOT NULL UNIQUE,
  SOLT VARCHAR(128),
  AVATAR_URL VARCHAR(256) DEFAULT 'Noavatar.png'
);

CREATE TABLE ROOMS
(
  ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  NAME VARCHAR(32) NOT NULL,
  PASSWORD VARCHAR(128),
  NUM_PLAYERS INT NOT NULL,
  INITIAL_MONEY INT NOT NULL,
  TURN_TIME INT NOT NULL
);


CREATE TABLE PLAYERS
(
  ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  USER_ID INT NOT NULL,
  ROOM_ID INT NOT NULL,
  MONEY INT NOT NULL,
  IS_ALIVE BOOLEAN NOT NULL,
  IS_TURN BOOLEAN NOT NULL,
  POSITION INT NOT NULL,
  FOREIGN KEY (USER_ID) REFERENCES USERS(ID),
  FOREIGN KEY (ROOM_ID) REFERENCES ROOMS(ID)
);

CREATE TABLE PROPERTIES
(
  ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  TITLE VARCHAR(32) NOT NULL,
  CARD_TYPE INT NOT NULL,
  PRICE INT NOT NULL,
  RENT INT,
  HOUSES_1 INT NOT NULL,
  HOUSES_2 INT NOT NULL,
  HOUSES_3 INT,
  HOUSES_4 INT,
  HOUSES_5 INT,
  HOUSE_COST INT
);

CREATE TABLE CELLS
(
  ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  BOARD_ID INT NOT NULL,
  LOCATION INT NOT NULL,
  CELL_TYPE VARCHAR(32) NOT NULL,
  PROPERTY_ID INT,
  FOREIGN KEY (PROPERTY_ID) REFERENCES PROPERTIES(ID)
);

CREATE TABLE INFO_CARDS
(
  ID INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  TYPE_NAME VARCHAR(32) NOT NULL,
  MESSAGE VARCHAR(128) NOT NULL,
  ACTION VARCHAR(512) NOT NULL
);

CREATE TABLE GAME_CARDS
(
  ROOM_ID INT NOT NULL,
  INFO_CARD_ID INT NOT NULL,
  NUMBER INT NOT NULL,
  OWNER_ID INT,
  FOREIGN KEY (ROOM_ID) REFERENCES ROOMS(ID),
  FOREIGN KEY (INFO_CARD_ID) REFERENCES INFO_CARDS(ID),
  FOREIGN KEY (OWNER_ID) REFERENCES PLAYERS(ID)
);

CREATE TABLE PLAYERS_PROPERTIES
(
  PLAYER_ID INT NOT NULL,
  PROPERTY_ID INT NOT NULL,
  HOMES INT,
  IS_MORTRAGE BOOLEAN NOT NULL,
  FOREIGN KEY (PLAYER_ID) REFERENCES PLAYERS(ID),
  FOREIGN KEY (PROPERTY_ID) REFERENCES PROPERTIES(ID)
);





INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Community Chest', 'Advance to Go (Collect $200)', '<location>0</location>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Community Chest', 'Bank error in your favor – Collect $200', '<money>200</money>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Community Chest', 'Doctors fees – Pay $50', '<money>50</money>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Community Chest', 'From sale of stock you get $50', '<money>50</money>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Community Chest', 'Get Out of Jail Free – This card may be kept until needed or sold', '<outOfJail>true</outOfJail>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Community Chest', 'Go to Jail – Do not pass Go – Do not collect $200', '<location>30</location><finish>true</finish>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Community Chest', 'Grand Opera Night – Collect $50 from every player for opening night seats', '<foreach>50</foreach>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Community Chest', 'Holiday Fund matures - Receive $100', '<money>100</money>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Community Chest', 'Income tax refund – Collect $20', '<money>20</money>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Community Chest', 'It is your birthday - Collect $10 from each player', '<foreach>10</foreach>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Community Chest', 'Life insurance matures – Collect $100', '<money>100</money>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Community Chest', 'Pay hospital fees of $100', '<money>-100</money>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Community Chest', 'You are assessed for street repairs – $40 per house – $115 per hotel', '<forHouse>40</forHouse><forHotel>115</forHotel>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Community Chest', 'Pay school fees of $150', '<money>-150</money>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Community Chest', 'Receive $25 consultancy fee', '<money>25</money>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Community Chest', 'You have won second prize in a beauty contest – Collect $10', '<money>10</money>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Community Chest', 'You inherit $100', '<money>100</money>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Chance', 'Advance to Go (Collect $200)', '<location>0</location>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Chance', 'Advance to Illinois Ave. - If you pass Go, collect $200', '<location>23</location><finish>true</finish>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Chance', 'Advance to St. Charles Place – If you pass Go, collect $200', '<location>11</location><finish>true</finish>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Chance', 'Advance token to nearest Utility. If unowned, you may buy it from the Bank. If owned, throw dice and pay owner a total ten times the amount thrown.', 
'<location>12</location><location>28</location><finish>true</finish><payMore>true</payMore>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Chance', 'Advance token to the nearest Railroad and pay owner twice the rental to which he/she is otherwise entitled. If Railroad is unowned, you may buy it from the Bank.', 
'<location>5</location><location>15</location><location>25</location><location>35</location><finish>true</finish><payMore>true</payMore>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Chance', 'Bank pays you dividend of $50', '<money>50</money>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Chance', ' Get out of Jail Free – This card may be kept until needed, or traded/sold', '<outOfJail>true</outOfJail>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Chance', 'Go Back 3 Spaces', '<location>-3</location><finish>false</finish>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Chance', 'Go to Jail – Go directly to Jail – Do not pass Go, do not collect $200', '<location>30</location><finish>true</finish>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Chance', 'Make general repairs on all your property – For each house pay $25 – For each hotel $100', '<forHouse>-25</forHouse><forHotel>-100</forHotel>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Chance', 'Pay poor tax of $15', '<money>-15</money>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Chance', 'Take a trip to Reading Railroad', '<location>25</location><finish>true</finish>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Chance', 'Take a walk on the Boardwalk – Advance token to Boardwalk', '<location>39</location><finish>true</finish>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Chance', 'You have been elected Chairman of the Board – Pay each player $50', '<foreach>-50</foreach>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Chance', 'Your building loan matures – Collect $150', '<money>150</money>');
INSERT INTO INFO_CARDS (TYPE_NAME, MESSAGE, ACTION) 
VALUES ('Chance', 'You have won a crossword competition - Collect $100', '<money>100</money>');



INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Mediterranean Avenue', 1, 60, 2, 10, 30, 90, 160, 250, 50);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Baltic Avenue', 1, 60, 4, 20, 60, 180, 320, 450, 50);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Oriental Avenue', 2, 100, 6, 30, 90, 270, 400, 550, 50);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Vermont Avenue', 2, 100, 6, 30, 90, 270, 400, 550, 50);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Connecticut Avenue', 2, 120, 8, 40, 100, 300, 450, 600, 50);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('St. Charles Place', 3, 140, 10, 50, 150, 450, 625, 750, 100);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('States Avenue', 3, 140, 10, 50, 150, 450, 625, 750, 100);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Virginia Avenue', 3, 160, 12, 60, 180, 500, 700, 900, 100);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('St. James Place', 4, 180, 14, 70, 200, 550, 750, 950, 100);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Tennessee Avenue', 4, 180, 14, 70, 200, 550, 750, 950, 100);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('New York Avenue', 4, 200, 16, 80, 220, 600, 800, 1000, 100);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Kentucky Avenue', 5, 220, 18, 90, 250, 700, 875, 1050, 150);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Indiana Avenue', 5, 220, 18, 90, 250, 700, 875, 1050, 150);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Illinois Avenue', 5, 240, 20, 100, 300, 750, 925, 1100, 150);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Atlantic Avenue', 6, 260, 22, 110, 330, 800, 975, 1150, 150);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Ventnor Avenue', 6, 260, 22, 110, 330, 800, 975, 1150, 150);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Marvin Gardens', 6, 280, 24, 120, 360, 850, 1025, 1200, 150);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Pacific Avenue', 7, 300, 26, 130, 390, 900, 1100, 1275, 200);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('North Carolina Avenue', 7, 300, 26, 130, 390, 900, 1100, 1275, 200);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Pennsylvania Avenue', 7, 320, 28, 150, 450, 1000, 1200, 1400, 200);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Park Place', 8, 350, 35, 175, 500, 1100, 1300, 1500, 200);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Boardwalk', 8, 400, 50, 200, 600, 1400, 1700, 2000, 200);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Reading Railroad', 9, 200, NULL, 25, 50, 100, 200, NULL, NULL);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Pennsylvania Railroad', 9, 200, NULL, 25, 50, 100, 200, NULL, NULL);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('B. & O. Railroad', 9, 200, NULL, 25, 50, 100, 200, NULL, NULL);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Short Line', 9, 200, NULL, 25, 50, 100, 200, NULL, NULL);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Electric Company', 10, 150, NULL, 4, 10, NULL, NULL, NULL, NULL);
INSERT INTO PROPERTIES (TITLE, CARD_TYPE, PRICE, RENT, HOUSES_1, HOUSES_2, HOUSES_3, HOUSES_4, HOUSES_5, HOUSE_COST) 
VALUES ('Water Works', 10, 150, NULL, 4, 10, NULL, NULL, NULL, NULL);




INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE) VALUES (0, 0, 'GO');
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 1, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Mediterranean Avenue'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE) VALUES (0, 2, 'COMMUNITY CHEST');
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 3, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Baltic Avenue'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE) VALUES (0, 4, 'TAX');
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 5, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Reading Railroad'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 6, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Oriental Avenue'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE) VALUES (0, 7, 'CHANCE');
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 8, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Vermont Avenue'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 9, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Connecticut Avenue'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE) VALUES (0, 10, 'JAIL');
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 11, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'St. Charles Place'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 12, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'States Avenue'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 13, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Electric Company'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 14, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Virginia Avenue'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 15, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Pennsylvania Railroad'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 16, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'St. James Place'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE) VALUES (0, 17, 'COMMUNITY CHEST');
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 18, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Tennessee Avenue'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 19, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'New York Avenue'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE) VALUES (0, 20, 'FREE PARKING');
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 21, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Kentucky Avenue'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE) VALUES (0, 22, 'CHANCE');
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 23, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Indiana Avenue'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 24, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Illinois Avenue'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 25, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'B. & O. Railroad'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 26, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Atlantic Avenue'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 27, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Ventnor Avenue'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 28, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Water Works'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 29, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Marvin Gardens'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE) VALUES (0, 30, 'GO TO JAIL');
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 31, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Pacific Avenue'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 32, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'North Carolina Avenue'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE) VALUES (0, 33, 'COMMUNITY CHEST');
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 34, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Pennsylvania Avenue'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 35, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Short Line'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE) VALUES (0, 36, 'CHANCE');
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 37, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Park Place'));
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE) VALUES (0, 38, 'LUXURY TAX');
INSERT INTO CELLS (BOARD_ID, LOCATION, CELL_TYPE, PROPERTY_ID) VALUES (0, 39, 'PROPERTY', (SELECT ID FROM PROPERTIES WHERE TITLE = 'Boardwalk'));
