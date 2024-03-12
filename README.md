just a simple chat app. 
installation:
- requirements:
  - LAMP server
- how to?
  - just run install.sh
  - if it isn't online at http://localhost you should also enable systemd service for apache
 

also if on production it's very advised to change default security settings by false'ing variable at top of index.php subsite cause by defult it have some security holes (putting raw HTML to page)...
