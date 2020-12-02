
---
---TRIGGERS AND UDF
---

DROP FUNCTION IF EXISTS notify_event_owner() CASCADE;
DROP FUNCTION IF EXISTS notify_reported_owner() CASCADE;
DROP FUNCTION IF EXISTS notify_attending_users() CASCADE;
 
DROP TRIGGER IF EXISTS notify_event_owner ON loan;
DROP TRIGGER IF EXISTS notify_reported_owner ON loan;
DROP TRIGGER IF EXISTS notify_attending_users ON wish_list;

 CREATE FUNCTION notify_event_owner() RETURNS TRIGGER AS 
$BODY$
BEGIN
    SELECT event.owner_id AS event_owner_id FROM "event" WHERE NEW.event_id = "event".id
    INSERT INTO "notification" (event_owner_id, TYPE, origin_id, description) VALUES (event_owner_id, "comment", NEW.id, 'New comment on your Event' )
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER notify_event_owner
    AFTER INSERT ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE notify_event_owner(); 
    

CREATE FUNCTION notify_reported_owner() RETURNS TRIGGER AS 
$BODY$
BEGIN
    SELECT comment.commenter_id AS reported_owner_id FROM comment WHERE NEW.comment_id = comment.commenter_id
    INSERT INTO "notification" (target_id, TYPE, origin_id, description) VALUES (reported_owner_id, "report", NEW.comment_id, 'One of your comments has been reported' )
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER notify_reported_owner
    AFTER INSERT ON report
    FOR EACH ROW
    EXECUTE PROCEDURE notify_reported_owner();
    
CREATE FUNCTION notify_attending_users() RETURNS TRIGGER AS 
$BODY$
BEGIN
    SELECT attending.attendee_id AS event_attendee_id FROM attending WHERE NEW.id = attending.event_id
    INSERT INTO "notification" (target_id, TYPE, origin_id, description) VALUES (event_attendee_id, 'changes', NEW.id, 'One of the events you are attending has been edited' )
    RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER notify_attending_users
    AFTER UPDATE ON event
    FOR EACH ROW
    EXECUTE PROCEDURE notify_attending_users(); 

---
---INDEXES
---
CREATE INDEX user_attending ON "event" USING btree (user_id); 
CREATE INDEX event_start ON "event" USING btree (start_date); 
CREATE INDEX event_start ON "event" USING btree (end_date); 