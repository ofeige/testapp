testapp
=======

A simple application for testing OPF.

Installation
============

You need virtualbox (https://www.virtualbox.org/wiki/Downloads) and Vagrant (http://www.vagrantup.com/downloads.html)

At first check out with git:

<pre><code>git clone https://github.com/ofeige/testapp
cd testapp
git submodule init
git submodule update</code></pre>

at next you have to install composer (http://getcomposer.org/download/) and update all of the dependency from testapp. This will download opf and Twig. 
<pre><code>curl -sS https://getcomposer.org/installer | php
php composer.phar update</code></pre>

then you can build the virtual machine with 
<pre><code>vagrant up</code></pre>

After building a machine you can open a Browser Window and go to http://localhost:8081 to start with OPF

There is an admin user with password 123456.
