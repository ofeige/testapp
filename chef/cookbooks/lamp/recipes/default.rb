include_recipe "apt"
include_recipe "apache2::mod_php5"
include_recipe "apache2::mod_rewrite"
include_recipe "apache2::mod_deflate"
include_recipe "apache2::mod_headers"
include_recipe "mysql::server"

package "php5-mysqlnd" do
  action :install
end

web_app "my_site" do
  server_name "localhost"
  server_aliases ["localhost"]
  docroot "/vagrant/public"
end