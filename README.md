# Node Red WordPress Companion Plugin

Magical things happen when you combine *WordPress* with *Node Red*. This plugine expands the capabilities of Node Red WordPress by adding endpoints for direct communication, as well as some nifty shortcodes for displaying data in real time on the front end of your site.

### Features
- Adds REST endpoints that allow getting and setting data variables from Node Red.
- Adds REST endpoints that allow fetching stats from Jetpack.
- Adds the `nodered_data` shortcode for adding real-time data points to the front end of your site.

### API Usage

The following new methods are exposed:

- Get data by key: `/wp-json/nrwp/v1/get/<key>`
- Set data: `/wp-json/nrwp/v1/set/<key>/<value>`
- Get data keys: `/wp-json/nrwp/v1/get_keys`
- Get all keys and data: `/wp-json/nrwp/v1/get_all`
- Get stats (when Jetpack is enabled): `/wp-json/nrwp/v1/get_stats`

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