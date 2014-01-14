testapp
=======

A simple application for testing OPF.

Installation
============

You need virtualbox (https://www.virtualbox.org/wiki/Downloads) and Vagrant (http://www.vagrantup.com/downloads.html)

At first check out with git:

git clone https://github.com/ofeige/testapp
cd testapp
git submodule init
git submodule update

then you can build the virtual machine with 
vagrant up

After building a machine you can open a Browser Window and go to http://localhost:8081 to start with OPF
