VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.provider :parallels do |vb|
    # Don't boot with headless mode
    vb.gui = false
    #   # Use VBoxManage to customize the VM. For example to change memory:
    vb.customize ["modifyvm", :id, "--memory", "512"]
  end


  config.vm.box = "precise32"
  config.vm.box_url = "http://files.vagrantup.com/precise32.box"
  config.vm.network :forwarded_port, guest: 80, host: 8081
  config.vm.network :forwarded_port, guest: 3306, host: 3306

  config.vm.synced_folder ".", "/var/www", :owner => "www-data", :group => "www-data"

  config.vm.provision :chef_solo do |chef|
    chef.cookbooks_path = ["vendor/chef/cookbooks/"]
    chef.add_recipe("lamp")
    chef.json = {
      "mysql"=>{
        "server_root_password" => "",
        "server_repl_password" => "",
        "server_debian_password" => ""
      }
    }
  end
end
