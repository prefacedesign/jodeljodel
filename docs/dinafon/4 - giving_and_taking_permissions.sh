#granting permission

./cake acl grant all_users public_page all
./cake acl grant editors backstage_area all
./cake acl grant redactors backstage_area read 
./cake acl grant redactors backstage_area edit 
./cake acl grant redactors backstage_area create
./cake acl grant techies backstage_area all
./cake acl grant superusers all_pages all