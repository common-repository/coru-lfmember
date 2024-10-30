=== Coru LFMember ===
Contributors: coruin
Donate link: http://www.ruelicke.net/
Tags: warcraft, member, mmorpg
Requires at least: 2.9.2
Tested up to: 3.0.1
Stable tag: 1.0.2

A Wordpress plugin, which allows a guild or clan to display if they are looking for members or not.

== Description ==

Coru LFMember is a Wordpress plugin, which allows a guild or clan to display if they are looking for members or not.
Right now the plugin is target at World of Warcraft guilds, however, other games will follow later.

== Installation ==


1. Upload the "coru-lfmember" folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place `<?php if (function_exists('coru_lfmember_display')) { coru_lfmember_display('game_name','return as array= true, else false','optional: before_html_tag','optional: after_html_tag'); } ?>` into your template (sidebar). e.g. `coru_lfmember_display('WoW',true,'','');` will return all open positions for "WoW" as an array which may be used to modify the display as you please `coru_lfmember_display('WoW',false,'<div>','</div>');` will return all open positions for "WoW". Each position is inside a `<div>`-tag.

== Frequently Asked Questions ==

= Did you create that World of Warcraft Icons? =
Nope, Blizzard did, just copied them. All rights for that icon belong to Blizzard.

= Why is your FAQ so short? =
It is short because noone asked me questions about the plugin. Go ahead an ask your questions!

== Screenshots ==

coming soon

== Changelog ==

= 1.0.2 =
* Works with Wordpress 3.0.1

= 1.0.1 =
* Fixed not shown icons at the game position overview.

= 1.0 =
initial release:
* Options to add, remove, enable or disable Games
* Options to add or remove "positions" to a selected game, also to set the positiosn to "open" or "closed"
* Default Install (= Plugin activation): Adds World of Warcraft as game together with a set of positions
* Plugin deactivation: deletes the database tables added by the plugin, thus deleting all created games and positions

== Upgrade Notice ==

= 1.0.1 =
* just replace the files

= 1.0 =
* Since it is the first release, there is nothing to worry about upgrading

== Todo ==
* Adding option to uninstall the database tables manually
* Making sure the database tables are no longer deleted upon deactivation of the addon
* Writing a better documentation + commenting the code
* Adding support for multiple languages
* Providing some screens