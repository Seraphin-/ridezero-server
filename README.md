RideZero Custom Server
----------------------

For PHP.

Make sure to edit config.php to point to a sqlite3 database with the sql dumps in "sql" imported.

Use it with a DNS server to point these addresses to your server and set up a VirtualHost (for apache) or similar to the contents of this repo:

	d2jqbnnyybfqtp.cloudfront.net
	rz13-459974764.ap-northeast-2.elb.amazonaws.com
	rz12-1672000475.ap-northeast-2.elb.amazonaws.com

Score saving and some story/achievemnent stuff is implemented. There is also code to make webui stuff which was never really finished.
However, beware, nothing is tested well.

The score saving method is also terrible, I know. This code is pretty old.

The \_dump folder contains example request/response data from the official server if you want to implement other stuff.