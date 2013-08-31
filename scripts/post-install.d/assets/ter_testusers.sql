INSERT INTO fe_users(pid, username, password, deleted, disable) VALUES ('11', 'autotest-alice',     'alice-password', 0, 0);
INSERT INTO fe_users(pid, username, password, deleted, disable) VALUES ('11', 'autotest-bob',       'bob-password',   0, 0);
INSERT INTO fe_users(pid, username, password, deleted, disable) VALUES ('11', 'autotest-eve',       'eve-password',   0, 0);

# this user has some password with special chars
INSERT INTO fe_users(pid, username, password, deleted, disable) VALUES ('11', 'autotest-weiredo',   '¢rÜpt|c',   0, 0);
