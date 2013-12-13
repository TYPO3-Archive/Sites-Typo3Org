# alices password is "alice-password"
INSERT INTO fe_users(pid, username, password, deleted, disable) VALUES ('11', 'autotest-alice',     '$P$CzHsG8cRdmY0mytc.fRql8YS0ZaSm4.', 0, 0);
# bobs password is "bob-password"
INSERT INTO fe_users(pid, username, password, deleted, disable) VALUES ('11', 'autotest-bob',       '$P$CIwnePvuHIlmP3gIr8Hxw6rvSkxtZo.',   0, 0);
# eves password is "eve-password"
INSERT INTO fe_users(pid, username, password, deleted, disable) VALUES ('11', 'autotest-eve',       '$P$CcvkV4CcmzlFTbmn/BIJd2rmXQrExO.',   0, 0);

# this user has some password with special chars
# password "¢rÜpt|c"
INSERT INTO fe_users(pid, username, password, deleted, disable) VALUES ('11', 'autotest-weiredo',   '$P$CMaGbWQ4WI7ROftZ1nmYkiKFqDYyxe1',   0, 0);

# this user is in the "TER reviewer" group
# password "reviewer-password"
INSERT INTO fe_users(pid, username, password, usergroup, deleted, disable) VALUES ('11', 'autotest-reviewer',   '$P$C2TnUnDot0jCZumvCk9OokcxFT3Qhd.', 22, 0, 0);
# this user is in the "TER Administrator" group
# password "admin-password"
INSERT INTO fe_users(pid, username, password, usergroup, deleted, disable) VALUES ('11', 'autotest-admin',   '$P$CGt3Pr.uPi928UTlIir3qdPqGb7zvk/', 26, 0, 0);
