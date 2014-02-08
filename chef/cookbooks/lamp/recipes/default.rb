include_recipe "apt"
include_recipe "chef-dotdeb::php54"

include_recipe "mysql"
include_recipe "mysql::server"

include_recipe "apache2::mod_php5"
include_recipe "apache2::mod_rewrite"
include_recipe "apache2::mod_deflate"
include_recipe "apache2::mod_headers"

include_recipe "database::mysql"


mysql_connection_info = {
  :host     => 'localhost',
  :username => 'root',
  :password => node['mysql']['server_root_password']
}

mysql_database 'myapp' do
  connection mysql_connection_info
  action :create
end

#or import from a dump file
mysql_database "myapp" do
  connection mysql_connection_info
  sql { ::File.open('/vagrant/data/mysql.schema.sql').read }
  action :query
end

database_user 'myapp_user' do
  connection mysql_connection_info
  password   'super_secret'
  provider   Chef::Provider::Database::MysqlUser
  action     :create
end

mysql_database_user 'myapp_user' do
  connection    mysql_connection_info
  password      'super_secret'
  database_name 'myapp'
  host          '%'
  privileges    [:all]
  action        :grant
end

package "php5-mysqlnd" do
  action :install
end

web_app "opf_testapp" do
  server_name "localhost"
  server_aliases ["localhost"]
  docroot "/vagrant/public"
end

