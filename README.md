# Caldera forms http block

Add on for WordPress plugin Caldera forms.

With conditions in Caldera form you can block form submit if field contains unwanted content, but that doesn't stop spammers who use their own POST method. This plugin adds new processor with which you can select a field (with magic tags) that must not contain "http" in any form (not case sensitive, i.e. "Https" is blocked too), so it stops sending messages with website addresses in them in forms pre-process stage.

Error messages and processor comments in Finnish, they can be changed on lines 25, 66 and 70 in caldera-form-blocker.php. Translations:

25: 'Estä http sisältävä kenttä' -> 'Block field containing http'

66: 'Korjaa kenttä %s' -> 'Fix field %s' (where %s is field name)

70: 'Verkko-osoitteet viestissä kielletty' -> 'Website addresses in message forbidden'

### Installation and usage:
- Install plugin by copying caldera-form-blocker dir to your wp-content/plugins dir or zip caldera-form-blocker and upload it in WordPress.
- In Caldera forms plugin page choose your form and go to processors.
- Add "Estä http sisältävä kenttä" named processor (or whatever you changed it to on line 25), choose magic tag for message field and save settings.
- You can test plugin functionality by submitting otherwise valid form, but with http or https in message field.
