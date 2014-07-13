# ComposePOT — WordPress POT tools reboot

ComposePOT (`compot`) is a fork of MakePOT tools (and related classes) for working with gettext files from WordPress core.

It aims to decouple said code from WordPress core dependency and sprinkle it with fairy dust of modern PHP and stuff.

So work in progress you have no idea I don't even.

# Installation and usage

```
git clone https://github.com/Rarst/ComposePOT
cd ComposePOT
composer install --no-dev
php compot.php
```

```
Available commands:
  help              Displays help for a command
  list              Lists commands
add
  add:domain        Add text domain to translation calls in source
extract
  extract:strings   Generate POT file from the files in directory
```