include_recipe "apt"
include_recipe "build-essential"
include_recipe "mysql::server"
include_recipe "database::mysql"
include_recipe "apache2::mod_php5"
include_recipe "apache2::mod_rewrite"
include_recipe "apache2::mod_deflate"
include_recipe "apache2::mod_headers"

mysql_database 'myapp' do
  connection(
    :host     => 'localhost',
    :username => 'root',
    :password => node['mysql']['server_root_password']
  )
  action :create
end

#or import from a dump file
mysql_database "myapp" do
  connection(
      :host     => 'localhost',
      :username => 'root',
      :password => node['mysql']['server_root_password']
    )
  sql { ::File.open('/vagrant/data/mysql.schema.sql').read }
  action :query
end

package "php5-mysqlnd" do
  action :install
end

web_app "opf_testapp" do
  server_name "localhost"
  server_aliases ["localhost"]
  docroot "/vagrant/public"
end

