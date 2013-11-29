# alices password is "alice-password"
INSERT INTO fe_users(pid, username, password, deleted, disable) VALUES ('11', 'autotest-alice',     '$P$CzHsG8cRdmY0mytc.fRql8YS0ZaSm4.', 0, 0);
# bobs password is "bob-password"
INSERT INTO fe_users(pid, username, password, deleted, disable) VALUES ('11', 'autotest-bob',       '$P$CIwnePvuHIlmP3gIr8Hxw6rvSkxtZo.',   0, 0);
# eves password is "eve-password"
INSERT INTO fe_users(pid, username, password, deleted, disable) VALUES ('11', 'autotest-eve',       '$P$CcvkV4CcmzlFTbmn/BIJd2rmXQrExO.',   0, 0);

# this user has some password with special chars
# password "¢rÜpt|c"
INSERT INTO fe_users(pid, username, password, deleted, disable) VALUES ('11', 'autotest-weiredo',   '$P$CMaGbWQ4WI7ROftZ1nmYkiKFqDYyxe1',   0, 0);
