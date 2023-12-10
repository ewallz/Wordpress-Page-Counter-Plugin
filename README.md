# Wordpress-Page-Counter-Plugin
Simple and lightweight Wordpress website counter plugin that display site visit statistic based on pageview or page hits. No cookies, no js, no external services.

Wordpress Site Counter Page Visit Plugin
The WP Simple Page Count plugin is a versatile and lightweight tool designed to effortlessly track and display page view statistics on your WordPress website. It can also be used as Wordpress Site Counter. Whether you're a blogger, business owner, or developer, this plugin provides an easy way to showcase your page hits with customizable shortcodes and a sleek, modern widget.

Demo: https://www.ewallzsolutions.com/wordpress-simple-pageview-sitecounter-plugin/

Features:
Flexible Shortcodes: Easily integrate page view statistics anywhere on your site using the shortcode like this:

[ewpg_page_views total="yes" startno="100"]

Customizable Display: Tailor the widget to your preferences with adjustable parameters such as total count, today's count, weekly count, monthly count, and a add custom starting number for the total count.

Styling Options: The plugin offers multiple style options, allowing users to choose from various layouts to match their website's aesthetic.

Notes: 
- Accuracy wise, this plugin does not represent actual or accurate pageview the page is getting from a real site visitor. Since it is purely based on site reload, accuracy is not my main goal here.
- The counter might not working as intended on certain elements such as Theme Custom Sidebar, Custom Posts type, Page Builder elements, etc. As long as the plugin is able to detect the page/post ID, it should be working.

How to Use:

Download the plugin zip and extract it in Wordpress /plugins folder.

Shortcode Integration: Place [ewpg_page_views] (remove the dot) in any post, page, or widget to display the default page view statistics. Users can also customize the display using parameters. By default, the shortcode will display all stats in the widget using style 1.

[ewpg_page_views total="yes" today="yes" weekly="yes" monthly="yes" startno="3100" credit="no"]

The counter will be based on hits received by each Wordpress page_id, therefore a new row that stores the page hits counter will be created for each page. Default page ID will be 1. So, if you have 10 pages, there will be only 10 entries created & updated in the plugin's database table. The created database table will be deleted upon plugin deletion.

The counter values will reset via wpcron scheduler: Today (every 24 hours), Weekly (Every Sunday), Monthly (Every end of month), Total value won't reset.

Custom Parameters:
total: Include total count (e.g., total="yes"). Value: yes
today: Include today's count (e.g., today="yes"). Value: yes
weekly: Include weekly count (e.g., weekly="yes"). Value: yes
monthly: Include monthly count (e.g., monthly="yes"). Value: yes
startno: Set a starting number for counts (e.g., startno="1000"). Value: numbers only
style: Choose from various widget styles (1-5, e.g., style="3"). Value: 1 to 5
credit: Hide the credit link with credit="no". Value: no
Example shortcodes:

To display Today & Total Hits with style 2: [ewpg_page_views today="yes" total="yes" style="2"] (remove the dot)
To display only Total Hits with custom startno: [ewpg_page_views total="yes" startno="3234"] (remove the dot)
Default Styling Override:
Users can easily override the default styling by modifying the included CSS file or by enqueueing their own styles. The CSS file is located in the /public/css/ folder. Users can also inspect the widget css to apply CSS override.

style 1: Inline horizontal labels with white text on dark background.
style 2: Vertical labels with white text on dark background.
style 3: Inline horizontal labels with white text on dark background, plus soft shadows.
style 4: Inline transparent horizontal labels with dark text and thick left border.
style 5: Vertical transparent labels with dark text and thick left border.
Enhance your WordPress experience with the WP Simple Page Count plugin, offering a seamless way to showcase your site's popularity and engage your audience.



Credit Link: By default, the plugin includes a discreet credit link, acknowledging the source of the page hit counter. Users can choose to hide this link using the credit="no" parameter.
