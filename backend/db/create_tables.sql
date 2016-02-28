CREATE TABLE Users(
  uid            INT             PRIMARY KEY NOT NULL,
  first_name     VARCHAR(25)     NOT NULL,
  last_name      VARCHAR(25)     NOT NULL,
  add_time       TIMESTAMP       NOT NULL
);


CREATE TABLE Stats(
  id            SERIAL      PRIMARY KEY NOT NULL,
  uid           INT         REFERENCES Users (uid),
  mobile        BOOLEAN     NOT NULL,
  app           INT         NOT NULL,
  start         TIMESTAMPTZ NOT NULL,
  finish        TIMESTAMPTZ NOT NULL
);
