CREATE TABLE Users(
  Uid           INT             PRIMARY KEY NOT NULL,
  FirstName     VARCHAR(25)     NOT NULL,
  LastName      VARCHAR(25)     NOT NULL,
  AddTime       TIMESTAMP       NOT NULL
);


CREATE TABLE Stats(
  Id            SERIAL      PRIMARY KEY NOT NULL,
  Uid           INT         REFERENCES Users (Uid),
  Online        BOOLEAN     NOT NULL,
  Mobile        BOOLEAN     NOT NULL,
  Time          TIMESTAMP   NOT NULL
);
