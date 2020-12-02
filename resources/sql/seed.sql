DROP TABLE IF EXISTS users CASCADE;
DROP TABLE IF EXISTS admins CASCADE;
DROP TABLE IF EXISTS "event" CASCADE;
DROP TABLE IF EXISTS events CASCADE;
DROP TABLE IF EXISTS attending CASCADE;
DROP TABLE IF EXISTS invited CASCADE;
DROP TABLE IF EXISTS comments CASCADE;
DROP TABLE IF EXISTS report CASCADE;
DROP TABLE IF EXISTS notifications CASCADE;
DROP TABLE IF EXISTS tags CASCADE;
DROP TABLE IF EXISTS poll CASCADE;
DROP TABLE IF EXISTS options CASCADE;
DROP TABLE IF EXISTS vote CASCADE;
DROP TABLE IF EXISTS event_image CASCADE;



DROP TYPE IF EXISTS NotificationType CASCADE;


-- Types
 
CREATE TYPE NotificationType AS ENUM ('invite', 'comment', 'report', 'changes');

-- DO ABOVE
 
-- Tables
 
 
CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    email text NOT NULL CONSTRAINT unique_email UNIQUE,
    name text NOT NULL,
    bio text,
    password text NOT NULL,
    photo text,
    join_date date NOT NULL,
    banned boolean NOT NULL
);
 

CREATE TABLE admins (
    id SERIAL PRIMARY KEY REFERENCES users (id) ON UPDATE CASCADE,
    admin_date date NOT NULL
);
 
CREATE TABLE events (
    id SERIAL PRIMARY KEY,
    owner_id BIGINT NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
    event_name text NOT NULL,
    description text NOT NULL,
    price bigint NOT NULL,
    start_date date NOT NULL,
    end_date date,
    paypal text,
    private_event boolean NOT NULL,
    location text NOT NULL,
    removed boolean NOT NULL DEFAULT false,
    CONSTRAINT date_check_1 CHECK (end_date > start_date),
    CONSTRAINT date_check_2 CHECK (start_date > CURRENT_DATE)
);

CREATE TABLE attending(
    event_id BIGINT NOT NULL REFERENCES events (id) ON UPDATE CASCADE,
    attendee_id BIGINT NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
    PRIMARY KEY (event_id, attendee_id)
);

CREATE TABLE invited(
    event_id BIGINT NOT NULL REFERENCES events (id) ON UPDATE CASCADE,
    invited_id BIGINT NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
    inviter_id BIGINT NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
    PRIMARY KEY (event_id, inviter_id, invited_id)
);
 
CREATE TABLE comments (
    id SERIAL PRIMARY KEY,
    commenter_id BIGINT NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
    event_id BIGINT NOT NULL REFERENCES events (id) ON UPDATE CASCADE,
    content text NOT NULL,
    photo text,
    removed text NOT NULL DEFAULT false
);
 
CREATE TABLE report (
    id SERIAL PRIMARY KEY,
    comment_id BIGINT NOT NULL REFERENCES comments (id) ON UPDATE CASCADE,
    report_note text NOT NULL
);

CREATE TABLE notifications(
    id SERIAL PRIMARY KEY,
    target_id BIGINT NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
    type int NOT NULL,
    origin_id BIGINT NOT NULL,
    description text NOT NULL
);
 
CREATE TABLE tags (
    id SERIAL PRIMARY KEY,
    tag text NOT NULL,
    event_id BIGINT NOT NULL REFERENCES events (id) ON UPDATE CASCADE
);
 
CREATE TABLE poll (
    id SERIAL PRIMARY KEY,
    question text NOT NULL,
    event_id BIGINT NOT NULL REFERENCES events (id) ON UPDATE CASCADE,
    target_id BIGINT NOT NULL REFERENCES users (id) ON UPDATE CASCADE
);
 
CREATE TABLE options (
    poll_id BIGINT NOT NULL REFERENCES poll (id) ON UPDATE CASCADE,
    content text NOT NULL,
    PRIMARY KEY (poll_id, content)
);

CREATE TABLE vote (
    poll_id BIGINT NOT NULL REFERENCES poll (id) ON UPDATE CASCADE,
    voter_id BIGINT NOT NULL REFERENCES users (id) ON UPDATE CASCADE,
    content text NOT NULL,
    PRIMARY KEY (poll_id, voter_id)
);

CREATE TABLE event_image (
    event_id BIGINT NOT NULL REFERENCES events (id) ON UPDATE CASCADE,
    image_url text NOT NULL,
    PRIMARY KEY (event_id, image_url)
);