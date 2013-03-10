TilePhlox
=========
MBTiles server in PHP with meta data support
--------------------------------------------

About
-----
This is a PHP implementation of the [MBTiles specification](https://github.com/mapbox/mbtiles-spec). It is slightly more advanced than [PHP-MBTiles-Server](https://github.com/bmcbride/PHP-MBTiles-Server) because it implements basic caching, improved error handling and adds support for meta data in the MBTiles database.

With this software you can set up a tile server using the MBTiles-file exported from [TileMill](https://github.com/mapbox/tilemill) on a server running Apache with PHP.

Dependencies
------------

Written in PHP, with [PDO](http://php.net/manual/en/ref.pdo-sqlite.php) enabled.
The supplied .htaccess-file contains URL rewriting rules for Apache with mod_rewrite installed but is not required.

Limitations
-----------
* Only supports PNG tiles, not JPEG.
* Does not implement UTF8Grid.

Usage
-----

Download the code, and place it all in the documentRoot of your tile server.

It is recommended that you host your tile server on its own (sub)domain. For example if you own the domain example.com you should create the subdomain tiles.example.com and host the tile server there. To allow concurrent download of more than 2 tiles at a time you can create various [serveraliases](http://httpd.apache.org/docs/2.4/vhosts/examples.html#intraextra) in Apache's virtualHost configuration. For example:

```
<VirtualHost 192.168.1.1 172.20.30.40>
    DocumentRoot /www/domains/tiles.example.com
    ServerName tiles.example.com
    ServerAlias tiles1.example.com tiles2.example.com tiles3.example.com tiles4.example.com
</VirtualHost>
```

Serving map tiles to many concurrent users may overload Apache. If you need more performance you should look into solutions based on Node.js or Nginx.

After installation place your .mbtiles files in the mbtiles directory. Tip: if you don't want to keep them somewhere else you can also create a symbolic link. While at it you should set the file permissions so that PHP cannot write to the MBTiles-file.

The tiles and meta data will be available under the following URLs:
```
http://tiles.example.com/mbtiles/[name of your database]/[z]/[x]/[y].png
http://tiles.example.com/metadata/[name of your database].json
```

For viewing the maps yo can use a javascript library like OpenLayers or [LeafletJS](http://leafletjs.com/). A demonstration script based on LeafletJS has been included in this repository.

Name
----
TilePhlox is named after [Doctor Phlox](http://en.memory-alpha.org/wiki/Phlox). One of the more entertaining characters from the television series Star Trek: Enterprise. Despite Doctor Phlox the show could unfortunately not live up to its expectations. This is a reminder that even though this software might work very well for you maximum performance cannot be achieved because it depends on PHP and Apache which are not the best foundation for serving map tiles.

License 
-------
This software is available under the terms of the BSD License.

Copyright (c) 2013, John Hoogstrate
All rights reserved.

Redistribution and use in source and binary forms, with or without
modification, are permitted provided that the following conditions are met:
* Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
* Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
* Neither the name of the <organization> nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL John Hoogstrate BE LIABLE FOR ANY
DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.