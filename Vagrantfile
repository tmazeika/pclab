# -*- mode: ruby -*-
# vi: set ft=ruby :
# noinspection RubyResolve

Vagrant.configure('2') do |config|
  config.vm.box = 'ubuntu/xenial64'
  config.vm.network :forwarded_port, guest: 5432, host: 5432

  config.vm.provision :ansible_local do |ansible|
    ansible.playbook = 'playbook.yml'
    ansible.install_mode = 'pip'
  end
end
