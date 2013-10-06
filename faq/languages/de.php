<?php
$german = array(
// Main Title
'faq' => "Frequently Asked Questions",
'faq:title' => "Frequently Asked Questions",
'faq:shorttitle' => "FAQ",
'faq:sidebar:categories' => "FAQ-Kategorien",

'item:object:faq' => "FAQs",

// add
'faq:add' => "Neue FAQ",
'faq:add:title' => "Neue Frequently Asked Question",
'faq:add:question' => "Frage",
'faq:add:category' => "Kategorie",
'faq:add:answer' => "Antwort",

'faq:add:oldcat:please' => "Wähle eine Kategorie",
'faq:add:oldcat:new' => "Gebe eine neue Kategorie ein:",

'faq:add:check:question' => "Bitte gebe eine Frage ein.",
'faq:add:check:category' => "Bitte gebe eine Kategorie an.",
'faq:add:check:answer' => "Bitte gebe eine Antwort ein.",

'faq:add:error:invalid_input' => "Fehler beim Speichern: falsche Eingabe. Bitte überprüfe alle Eingabefelder.",
'faq:add:error:save' => "Beim Speichern ist ein unbekannter Fehler aufgetreten.",
'faq:add:success' => "Die neue FAQ wurde hinzugefügt.",

// edit
'faq:edit:title' => "Frequently Asked Question bearbeiten",
'faq:edit:error:invalid_input' => "Fehler beim Speichern: falsche Eingabe. Bitte überprüfe alle Eingabefelder.",
'faq:edit:error:invalid_object' => "Fehler beim Bearbeiten: ungültiges Objekt. Es scheint, dass die FAQ, die Du bearbeiten willst, nicht vorhanden ist.",
'faq:edit:error:save' => "Beim Speichern ist ein unbekannter Fehler aufgetreten.",
'faq:edit:success' => "Die FAQ wurde aktualisiert.",

// delete
'faq:delete:confirm' => "Bist Du sicher, dass Du diese FAQ löschen willst?",
'faq:delete:success' => "Die FAQ wurde gelöscht.",

// settings
'faq:settings:public' => "Soll der FAQ-Bereich für alle sichtbar sein? Ansonsten nur für Admins.",
'faq:settings:publicAvailable_sitemenu'  => "Soll der FAQ-Eintrag im Seitenmenu für nicht angemeldete Besucher sichtbar sein? ",
'faq:settings:publicAvailable_footerlink' => "Soll der FAQ-Link im Footer-Bereich der Seite für nicht angemeldete Besucher sichtbar sein? ",
'faq:settings:ask' => "Sollen Benutzer Fragen stellen dürfen? ",
'faq:settings:minimum_search_tag_size' => "Mindestlänge von Suchtags: ",
'faq:settings:minimum_hit_count' => "Mindestanzahl von Treffern der eingegebenen Suchtags: ",

// search
'faq:search:noresult' => "Keine passenden Treffer in den FAQs gefunden.",
'faq:search:hitcount' => "Treffer: ",
'faq:search:title' => "Suche in den FAQs",
'faq:search:label' => "Bitte gebe den/die Suchbegriff(e) ein, nach dem/denen in den FAQs gesucht werden soll: ",
'faq:search:description' => "(Die Mindestlänge von zulässigen Suchbegriffen ist %s Zeichen. Ein Begriff muss mindestens %s mal in allen FAQs enthalten sein, damit er in der Trefferliste berücksichtigt wird.)",

// List a category
'faq:list:category_title' => "Kategorie: ",
'faq:list:no_category' => "Es wurde keine gültige Kategorie angegeben.",
'faq:list:edit:new_category' => "Bitte geben eine neue Kategorie an.",
'faq:list:edit:confirm:question' => "Bitte bestätige die Verschiebung von ",
'faq:list:edit:confirm:category' => " FAQ(s) in die Kategorie ",
'faq:list:edit:category:please' => "Bitte wähle eine oder mehrere Fragen, die in eine andere Kategorie verschoben werden sollen.",
'faq:list:edit:begin' => "Kategorie ändern",
'faq:list:edit:all' => "Alle auswählen",
'faq:list:edit:none' => "Alle abwählen",
'faq:list:edit:select:choice' => "- Bitte wähle eine Kategorie",
'faq:list:edit:select:new' => "- Eine neue Kategorie anlegen",

// Change category
'faq:change_category:description' => "Wähle mindestens eine der oben aufgelisteten Fragen aus, um sie in eine andere Kategorie zu verschieben. Dann wähle eine der unten aufgeführten Kategorien als neue Kategorie aus. (Hinweis: um eine Kategorie umzubenennen, wähle alle Fragen dieser Kategorie aus und gebe unten den neuen Namen der Kategorie ein.)",
'faq:change_category:new_category' => "Neue Kategorie: ",
'faq:change_category:error:input' => "Unzulässige bzw. falsche Eingabe.",
'faq:change_category:error:no_faq' => "Es wurde kein FAQ-Objekt übergeben.",
'faq:change_category:error:save' => "Beim Speichern der FAQ ist ein Problem aufgetreten. Bitte versuche es noch einmal.",
'faq:change_category:success' => "Die FAQ wurde gespeichert.",

// Ask a question
'faq:ask' => "Neue Frage",
'faq:ask:title' => "Bitte stelle Deine Frage",
'faq:ask:description' => "Wurde Deine Frage noch nicht in den FAQs beantwortet? Dann stelle hier Deine Frage: ",
'faq:ask:description' => "(Möglicherweise wird Deine Frage zu den FAQs hinzugefügt, möglicherweise nicht. Auch wenn die Frage nicht zu den FAQs hinzugefügt wird, bekommst Du auf jeden Fall eine Antwort.)",
'faq:ask:button' => "Fragen",
'faq:ask:new_question:subject' => "Deine neue Frage ist angekommen",
'faq:ask:new_question:message' => "Danke, für Dein Interesse.

Wir werden versuchen, Deine Frage:

%s

so schnell und so gut wie möglich zu beantworten.

Falls Deine Frage auch für andere für Interesse ist, werden wir sie möglicherweise zu den FAQs hinzufügen. Du bekommst aber auf jeden Fall eine Antwort.",

'faq:ask:new_question:send' => "Deine Frage wurde hinzugefügt. Du wirst auch eine Benachrichtigung darüber erhalten.",
'faq:ask:error:not_send' => "Deine Frage wurde hinzugefügt, aber beim Versenden einer Bestätigung an Dich ist ein Problem aufgetreten.",
'faq:ask:error:save' => "Beim Abspeichern Deiner Frage ist ein Problem aufgetreten. Bitte versuche es noch einmal.",
'faq:ask:error:no_user' => "Es ist ein Fehler aufgetreten. Der Benutzername war ungültig.",
'faq:ask:error:input' => "Es ist ein Fehler aufgetreten. Die Eingaben waren ungültig. Bitte versuche es noch einmal.",
'faq:ask:notify:admin:subject' => "Es wurde eine neue Frage gestellt",
'faq:ask:notify:admin:message' => "Hallo %s,

In den FAQs wurde eine neue Frage gestellt.

Um die ausstehende(n) Frage(n) einzusehen, folge dem Link:
%s",

// View asked questions
'faq:asked' => "Fragen von Benutzern (%s)",
'faq:asked:title' => "Von Benutzern gestellte Fragen",
'faq:asked:no_questions' => "Derzeit gibt es keine unbeantworteten Fragen.",
'faq:asked:not_allowed' => "Im Moment dürfen Benutzer keine Fragen stellen. Falls Du dies erlauben willst, passe die Plugin-Einstellungen entspechend an.",
'faq:asked:added' => "Hinzugefügt:",
'faq:asked:add' => "Diese Frage zu den FAQs hinzufügen",
'faq:asked:by' => "Frage von: %s",
'faq:asked:check:add' => "Anwählen, falls diese Frage zu den FAQs hinzugefügt werden soll",

// Answer an asked question
'faq:answer:notify:subject' => "Deine Frage wurde beantwortet",
'faq:answer:notify:message:added:same' => "Die Frage:
%s

die Du uns gestellt hast, wurde beantwortet. Die Antwort kannst Du hier einsehen:

%s

Wie Du siehst, wurde Deine Frage auch zu den FAQs hinzugefügt.",
'faq:answer:notify:message:added:adjusted' => "Die Frage:
%s

die Du uns gestellt hast, wurde beantwortet. Allerdings haben wird die Frage umformuliert:
%s

Die Antwort kannst Du hier einsehen:

%s

Wie Du siehst, wurde Deine Frage auch zu den FAQs hinzugefügt.",
'faq:answer:success:added:send' => "Die Frage wurde zu den FAQs hinzugefügt und der Benutzer wurde benachrichtigt.",
'faq:answer:error:added:not_send' => "Die Frage wurde zu den FAQs hinzugefügt. Bei der Benachrichtigung des Benutzers ist aber leider ein Problem aufgetreten.",
'faq:answer:error:save' => "Beim Speichern der FAQs ist ein Problem aufgetreten.",
'faq:answer:error:remove' => "Beim Löschen der Frage ist ein Problem aufgetreten. Bitte versuche es noch einmal.",
'faq:answer:error:no_cat' => "Fehler: die ausgewählte Kategorie ist ungültig. Bitte versuche es noch einmal.",
'faq:answer:notify:not_added:same' => "Die Frage:
%s

die Du uns gestellt hast, wurde beantwortet. Die Antwort ist:

%s

Die Frage wurde nicht zu den FAQs hinzugefügt.",
'faq:answer:notify:not_added:adjusted' => "Die Frage:
%s

die Du uns gestellt hast, wurde beantwortet. Allerdings haben wird die Frage umformuliert:
%s

Die Antwort ist:

%s

Die Frage wurde nicht zu den FAQs hinzugefügt.",
'faq:answer:success:not_added:send' => "Dem Benutzer wurde eine Benachrichtigung mit der Antwort zugesendet.",
'faq:answer:error:not_added:not_send' => "Beim Versenden der Benachrichtigung an den Benutzer ist ein Problem aufgetreten.",
'faq:answer:error:no_faq' => "Fehler: kein gültiges FAQ-Objekt.",
'faq:answer:error:input' => "Fehler: die Eingaben waren ungültig. Bitte versuche es noch einmal.",

// Stats page
'faq:stats:categories' => "Die FAQs umfassen %s Kategorien,",
'faq:stats:questions' => " mit insgesamt %s Fragen/Antworten.",
'faq:stats:user' => "Es gibt %s ausstehende Fragen von Benutzern, die noch beantwortet werden müssen.",
);

add_translation("de", $german);
