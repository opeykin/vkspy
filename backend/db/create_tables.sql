CREATE TABLE Users(
  uid            INT             PRIMARY KEY NOT NULL,
  first_name     VARCHAR(25)     NOT NULL,
  last_name      VARCHAR(25)     NOT NULL,
  add_time       TIMESTAMP       NOT NULL
);


CREATE TABLE Stats(
  id            SERIAL      PRIMARY KEY NOT NULL,
  uid           INT         REFERENCES Users (uid),
  online        BOOLEAN     NOT NULL,
  mobile        BOOLEAN     NOT NULL,
  app           INT         NOT NULL,
  time          TIMESTAMPTZ NOT NULL
);
