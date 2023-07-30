-- #! sqlite
-- #{ table
-- #    { init
CREATE TABLE IF NOT EXISTS quests (
   name TEXT,
   completed INTEGER
);
-- #   }
-- #   { insert
-- #      :name string
-- #      :completed int
INSERT INTO quests (name, completed) VALUES (:name, :completed);
-- #    }
-- #    { select
-- #      :name string
SELECT * FROM quests WHERE name = :name;
-- #    }
-- #    { update
-- #      :name string
-- #      :completed int
UPDATE quests SET completed = :completed WHERE name = :name;
-- #    }
-- #    { drop
DROP TABLE quests;
-- #    }
-- # }