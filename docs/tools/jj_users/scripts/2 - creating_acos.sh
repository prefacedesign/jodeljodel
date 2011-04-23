#Creating the acos tree
#The tree to be created:
#
#public_page
#backstage_area
#	new_news
#page_sections_test
#	section_one
#	section_two
#		section_two_one


./cake acl create aco root all_pages
./cake acl create aco all_pages public_page
./cake acl create aco all_pages backstage_area
./cake acl create aco backstage_area new_news
./cake acl create aco all_pages page_sections_test
./cake acl create aco page_sections_test section1
./cake acl create aco page_sections_test section2
./cake acl create aco section2 section21

#granting permission
./cake acl grant all_users public_page all
./cake acl grant editors backstage_area all
./cake acl grant redactors backstage_area read 
./cake acl grant redactors backstage_area edit 
./cake acl grant redactors backstage_area create
./cake acl grant techies backstage_area all
./cake acl grant superusers all_pages all
