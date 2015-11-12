GRANT CONNECT ON DATABASE alex to vkspy_stat_collector;
GRANT USAGE ON SCHEMA public to vkspy_stat_collector;
GRANT SELECT ON ALL TABLES IN SCHEMA public TO vkspy_stat_collector;
GRANT SELECT, INSERT, UPDATE, DELETE ON ALL TABLES IN SCHEMA public TO vkspy_stat_collector;
GRANT USAGE, SELECT ON SEQUENCE stats_id_seq TO vkspy_stat_collector;
