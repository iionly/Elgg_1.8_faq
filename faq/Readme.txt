FAQ plugin for Elgg 1.8
Latest Version: 1.8.4
Released: 2013-10-13
Contact: iionly@gmx.de
License: GNU General Public License version 2
Copyright: (C) iionly 2012-2013, (C) ColdTrick 2009-2013



This plugin will add a FAQ section to your site.

Features:

- Admins can add / edit / delete FAQs,
- FAQs structured in custom categories,
- Users can ask questions. These questions (and your answers) can be added to FAQ or alternatively you can send the answer only back to the user,
- Full text FAQ search ordered by relevancy (hit count).

Installation:

1. copy the faq folder into the mod folder of your Elgg installation,
2. enable the plugin in the admin section of your site and configure the faq plugin settings.
3. add question and answers on your own or wait until users ask questions.


Version History

1.8.4 (by iionly):
    - Fixed error in activate.php.

1.8.3 (by iionly):

    - Some general code cleanup,
    - FAQ answer output in html instead of plain text (so formatting on input should show up on output),
    - FAQs to show up in site search results if matching seach query,
    - Fixed bug on answering user questions form that made category selection dropdown input behaving awkward (due to a missing </label>).

1.8.2 (by iionly):

    - Getting FAQ plugin to work for logged-out site visitors when walled-garden option is enabled,
    - Added German translation.

1.8.1 (by iionly):

    - FAQ site menu entry and footer link optionally visible when not logged in (plugin settings)

1.8.0 (by iionly):
    - Updated to work in Elgg 1.8,
    - Fixed errors of earlier version,
    - Revision of UI.

1.5:
    - Added: better category management
    - Added: simple stats on start page
    - Added: notification to the admins when a new question is asked
    - Changed: Notification to user when question/answer is added to FAQ
        - User will now receive a link to the answer
    - Changed: Category list view (including how it links)
    - Changed: Search display

1.1:
    - Added: Users can now ask a question
        - Admins can enable this function
        - Admins can answer only to the user or also add to the FAQ

1.0.1:
    - Fixed: Plugin not working when using subdirectories

1.0:
    - First release to the public
