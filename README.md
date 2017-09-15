# Node Red WordPress Companion Plugin

Magical things happen when you combine *WordPress* with *Node Red*. This plugine expands the capabilities of Node Red WordPress by adding endpoints for direct communication, as well as some nifty shortcodes for displaying data in real time on the front end of your site.

### Features
- Adds REST endpoints that allow getting and setting data variables from Node Red.
- Adds REST endpoints that allow fetching stats from Jetpack.
- Adds the `nodered_data` shortcode for adding real-time data points to the front end of your site.

### API Usage

The following new endpoints are exposed:

- Get data by key: `/wp-json/nrwp/v1/get/<key>`
- Set data: `/wp-json/nrwp/v1/set/<key>/<value>`
- Get data keys: `/wp-json/nrwp/v1/get_keys`
- Get all keys and data: `/wp-json/nrwp/v1/get_all`
- Get stats (when Jetpack is enabled): `/wp-json/nrwp/v1/get_stats`

Simplicity is key here. All API requests should use method `GET` and require no parameters.

### Shortcode Usage

Prime your site with data using the `set` API request above. For example, make the following requests from your terminal:

`curl -i https://yoursite.com/wp-json/nrwp/v1/set/temperature1/50.5`
`curl -i https://yoursite.com/wp-json/nrwp/v1/set/temperature2/78.3`

These data points can come from Node Red, or directly from other IOT devices.

Next, insert a shortcode in your post content:

`[nodered_data key="temperature1"]`

and/or

`[nodered_data key="temperature2"]`

Save and view your post. You'll notice the temperature reading in your post. As the value of the temperature is updated via rest, your post will reflect it in real-time, without a page refresh.

### Example Node Red Config

Import the following config into your Node Red host. Grab a Weather Underground API key and update the config. Update the API requests to reflect your site's URL. Deploy it and watch the magic happen.

`[{"id":"86d123de.30019","type":"tab","label":"Flow 1"},{"id":"ace1e6ea.527388","type":"bean","z":"","name":"TheBeannn","uuid":"558eebd59492402d8b1a3ee659de1b7c","connectiontype":"constant","connectiontimeout":"0"},{"id":"30a7b699.4d119a","type":"http request","z":"86d123de.30019","name":"","method":"GET","ret":"txt","url":"http://api.wunderground.com/api/<API_KEY>/conditions/q/CA/Whistler_BC.json","tls":"","x":170,"y":100,"wires":[["d9ba7aee.0c67e8"]]},{"id":"dd33b62f.0a5778","type":"inject","z":"86d123de.30019","name":"","topic":"","payload":"","payloadType":"date","repeat":"300","crontab":"","once":true,"x":130,"y":40,"wires":[["30a7b699.4d119a"]]},{"id":"d9ba7aee.0c67e8","type":"function","z":"86d123de.30019","name":"foo","func":"msg.payload = JSON.parse( msg.payload );\n\nreturn msg;\n","outputs":1,"noerr":0,"x":190,"y":160,"wires":[["53bbf3b3.8fc37c"]]},{"id":"1f7f35ae.4a9a8a","type":"debug","z":"86d123de.30019","name":"","active":true,"console":"false","complete":"true","x":790,"y":440,"wires":[]},{"id":"53bbf3b3.8fc37c","type":"change","z":"86d123de.30019","name":"","rules":[{"t":"set","p":"temp_c","pt":"msg","to":"payload.current_observation.temp_c","tot":"msg"},{"t":"set","p":"description","pt":"msg","to":"payload.current_observation.weather","tot":"msg"},{"t":"set","p":"wind_string","pt":"msg","to":"payload.current_observation.wind_string","tot":"msg"},{"t":"set","p":"wind_dir","pt":"msg","to":"payload.current_observation.wind_dir","tot":"msg"}],"action":"","property":"","from":"","to":"","reg":false,"x":220,"y":220,"wires":[["c6f35a27.ac6fc8","856747b4.9fc488","fe540496.3de318","b69f3f73.8edd"]]},{"id":"c6f35a27.ac6fc8","type":"http request","z":"86d123de.30019","name":"","method":"GET","ret":"txt","url":"http://yoursite.com/wp-json/nrwp/v1/set/whistlertemp/{{{temp_c}}}","tls":"","x":290,"y":280,"wires":[["1f7f35ae.4a9a8a"]]},{"id":"856747b4.9fc488","type":"http request","z":"86d123de.30019","name":"","method":"GET","ret":"txt","url":"http://yoursite.com/wp-json/nrwp/v1/set/whistlerdesc/{{{description}}}","tls":"","x":290,"y":320,"wires":[["1f7f35ae.4a9a8a"]]},{"id":"fe540496.3de318","type":"http request","z":"86d123de.30019","name":"","method":"GET","ret":"txt","url":"http://yoursite.com/wp-json/nrwp/v1/set/winddir/{{{wind_dir}}}","tls":"","x":290,"y":360,"wires":[["1f7f35ae.4a9a8a"]]},{"id":"b69f3f73.8edd","type":"http request","z":"86d123de.30019","name":"","method":"GET","ret":"txt","url":"http://yoursite.com/wp-json/nrwp/v1/set/windstring/{{{wind_string}}}","tls":"","x":290,"y":400,"wires":[["1f7f35ae.4a9a8a"]]},{"id":"d8c4da09.1a1678","type":"bean accel","z":"86d123de.30019","name":"ReadAccel","bean":"ace1e6ea.527388","x":210,"y":540,"wires":[["be527573.bcfa38","72cc5a40.4595e4","5ed1372d.1bae68"]]},{"id":"5c2ffc17.c81f64","type":"inject","z":"86d123de.30019","name":"","topic":"","payload":"","payloadType":"date","repeat":"5","crontab":"","once":true,"x":130,"y":480,"wires":[["d8c4da09.1a1678"]]},{"id":"be527573.bcfa38","type":"http request","z":"86d123de.30019","name":"","method":"GET","ret":"txt","url":"http://yoursite.com/wp-json/nrwp/v1/set/beanx/{{{accelX}}}","tls":"","x":390,"y":500,"wires":[["1f7f35ae.4a9a8a"]]},{"id":"72cc5a40.4595e4","type":"http request","z":"86d123de.30019","name":"","method":"GET","ret":"txt","url":"http://yoursite.com/wp-json/nrwp/v1/set/beany/{{{accelY}}}","tls":"","x":390,"y":540,"wires":[["1f7f35ae.4a9a8a"]]},{"id":"5ed1372d.1bae68","type":"http request","z":"86d123de.30019","name":"","method":"GET","ret":"txt","url":"http://yoursite.com/wp-json/nrwp/v1/set/beanz/{{{accelZ}}}","tls":"","x":390,"y":580,"wires":[["1f7f35ae.4a9a8a"]]}]`