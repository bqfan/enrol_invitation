<?php
// This file is part of the UCLA Site Invitation Plugin for Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings for component 'enrol_invitation'
 *
 * @package    enrol_invitation
 * @copyright  2013 UC Regents
 * @copyright  2011 Jerome Mouneyrac {@link http://www.moodleitandme.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

// Global strings.
$string['pluginname'] = 'Kutsu';
$string['pluginname_desc'] = 'Kutsu moduulin avulla kutsujen lähettäminen sähköpostitse. Näitä kutsuja voidaan käyttää vain kerran. Käyttäjät klikkaamalla sähköpostilinkkiä automaattisesti kirjoilla.';

// Email message strings.
$string['reminder'] = 'Muistutus: ';

$string['emailmsgtxt'] =
    'OHJEET:' . "\n" .
    '------------------------------------------------------------' . "\n" .
    'Sinut on kutsuttu käyttämään sivustoa: {$a->fullname}. Saat '.
    'täytyy kirjautua sisään vahvista pääsyn sivustoon. Neuvottava että ' .
    'klikkaamalla sivustolla pääsyä linkkiä tässä' .
    'sähköposti olet tunnustaa, että:' . "\n" .
    ' --olet henkilö, jolle tämä sähköpostin oli osoitettu ja joille tämä' .
    '   kutsu on tarkoitettu;' . "\n" .
    ' --linkistä päättyy ({$a->expiration}).' . "\n\n" .
    'PÄÄSY LINKKI:' . "\n" .
    '------------------------------------------------------------' . "\n" .
    '{$a->inviteurl}' . "\n\n" .
    'Jos uskot, että olet saanut tämän viestin vahingossa tai ' .
    'ovat avun tarpeessa, ota yhteyttä: {$a->supportemail}.';

$string['instructormsg'] =
    'VIESTI OHJAAJASTA:' . "\n" .
    '------------------------------------------------------------' . "\n" .
    '{$a}' . "\n\n";

// Invite form strings.
$string['assignrole'] = 'Määritä rooli';
$string['defaultrole'] = 'Oletus rooli toimeksianto';
$string['defaultrole_desc'] = 'Valitse tehtävä, joka pitäisi antaa käyttäjille aikana kutsun ilmoittautumiset';
$string['default_subject'] = 'kutsu {$a}lle';

$string['editenrollment'] = 'Muokkaa ilmoittautuminen';

$string['header_email'] = 'Kenet haluat kutsua?';
$string['emailaddressnumber'] = 'Sähköpostiosoite';

$string['notifymsg'] = 'Hei, Haluan kertoa teille, että käyttäjä $a->username käyttäjätunnusta, sähköpostilla $a->email on onnistunut päässyt käyttämään kurssin, $a->course';


$string['emailtitleuserenrolled'] = '{$a->userfullname} on hyväksynyt kutsun {$a->coursefullname}.';
$string['emailmessageuserenrolled'] = 'Hei,

    {$a->userfullname} ({$a->useremail}) on hyväksynyt kutsun käyttää {$a->coursefullname} kuin "{$a->rolename}". Voit tarkistaa tilan tämän kutsun katsomalla joko:

        * Osallistujalista: {$a->courseenrolledusersurl}
        * Kutsu historia: {$a->invitehistoryurl}

    {$a->sitename}
    -------------
    {$a->supportemail}';

$string['enrolenddate'] = 'Pääsy lopetuspäivämäärää';
$string['enrolenddate_help'] = 'Jos käytössä, on päivä kutsuttavan enää pysty käyttämään sivustoa.';
$string['enrolenddaterror'] = 'Pääsy päättymispäivää ei voi olla aikaisintaan tänään';
$string['enrolperiod'] = 'ilmoittautuminen kesto';
$string['enrolperiod_desc'] = 'Oletus ajan pituus, ilmoittautuminen on voimassa (sekunneissa). Jos asetus on nolla, ilmoittautuminen kesto on rajoittamaton oletuksena.';
$string['enrolperiod_help'] = 'Aika, että ilmoittautuminen on voimassa alkaen kun käyttäjä on kirjoilla. Jos poistettu käytöstä, ilmoittautuminen kesto on rajoittamaton.';
$string['enrolstartdate'] = 'Aloituspäivä';
$string['enrolstartdate_help'] = 'Jos käytössä, käyttäjät voivat olla kirjoilla tästä päivästä lähtien vain.';
$string['editenrolment'] = 'Muokkaa ilmoittautuminen';
$string['inviteexpiration'] = 'Kutsu päättyminen';
$string['inviteexpiration_desc'] = 'Aika, että kutsu on voimassa (sekunneissa). Oletus on 2 viikkoa.';

$string['show_from_email'] = 'Salli kutsuttu käyttäjä ottaa yhteyttä minuun {$a->email} (osoitteesi tulee olemaan "FROM" -kenttään. Jos ei valittuna, "FROM" kentässä on {$a->supportemail})';
$string['inviteusers'] = 'Kutsu käyttäjä';
$string['maxinviteerror'] = 'Sen täytyy olla numero.';
$string['maxinviteperday'] = 'MSuurin kutsu päivässä';
$string['maxinviteperday_help'] = 'Suurin kutsu voidaan lähettää päivässä kurssin.';
$string['message'] = 'Viesti';

$string['message_help_link'] = 'mitä ohjeita kutsutuille lähetetään';
$string['message_help'] =
    'OHJEET:'.
    '<hr />'.
    'Sinut on kutsuttu käyttää sivustoa: [site name]. Saat '.
    'täytyy kirjautua sisään vahvista pääsyä sivustolle. Neuvottava että '.
    'klikkaamalla sivustolla pääsyä linkkiä tässä'.
    'sähköposti olet tunnustaa, että: <br /> '.
    '  --Ovat jolle tämän sähköpostin oli osoitettu ja joille tämä'.
    'Kutsu on tarkoitettu; <br />'.
    '  --The Linkistä päättyy ([voimassaoloaika]). <br /> <br />'.
    'PÄÄSY LINKKI:'.
    '<hr />'.
    '[kutsu url] <br />'.
    '<hr />'.
    'Jos uskot, että olet saanut tämän viestin vahingossa tai tarvitsevat'.
    'Tuen, ota yhteys: [tukeen sähköposti].';

$string['noinvitationinstanceset'] = 'Ei kutsu ilmoittautuminen esimerkiksi on löytynyt. Lisätkää kutsun ilmoittautua esimerkiksi oman kurssin ensin.';
$string['nopermissiontosendinvitation'] = 'Ei lupaa lähettää kutsu';
$string['norole'] = 'Valitse rooli.';
$string['notify_inviter'] = 'Muistuta minua {$a->email} kun kutsutut käyttäjät hyväksyvät tämän kutsun';
$string['header_role'] = 'Mikä rooli haluat määrittää kutsuttavan?';
$string['email_clarification'] = 'Voit määrittää useita sähköpostiosoitteita erottamalla
     ne puolipistettä, pilkkuja, välilyöntejä tai uusia linjoja';
$string['subject'] = 'Aihe';
$string['status'] = 'Salli kutsut';
$string['status_desc'] = 'Salli käyttäjien kutsua ihmisiä ilmoittautua kurssin oletuksena.';
$string['unenrol'] = 'Kirjautumatta käyttäjä';
$string['unenroluser'] = 'Haluatko varmasti käytöstä poistaminen "{$a->user}" kurssin "{$a->course}"?';
$string['unenrolselfconfirm'] = 'Haluatko todella Käytöstä poistaminen itsesi kurssi "{$a}"?';

// After invite sent strings.
$string['invitationsuccess'] = 'Kutsu onnistuneesti lähetetty';
$string['revoke_invite_sucess'] = 'Kutsu onnistuneesti kumottu';
$string['extend_invite_sucess'] = 'Kutsu onnistuneesti laajennettu';
$string['resend_invite_sucess'] = 'Kutsu onnistuneesti lähetetty uudelleen';
$string['returntocourse'] = 'Paluu kurssi';
$string['returntoinvite'] = 'Lähetä toinen kutsu';

// Processing invitation acceptance strings.
$string['invitation_acceptance_title'] = 'Kutsu hyväksyntä';
$string['expiredtoken'] = 'Kutsu symbolinen on päättynyt tai on jo käytetty.';
$string['loggedinnot'] = '<p>Tämä kutsu käyttää "{$a->coursefullname}", kuten
    "{$a->rolename}" on tarkoitettu {$a->email}. Jos et ole
     tarkoitettu vastaanottaja, älä hyväksy tätä kutsua.</p>
     <p>
         Ennen kuin voit hyväksyä tämän kutsun sinun täytyy kirjautua sisään.
     </p>';
$string ['invitationacceptance'] = '<p>Tämä kutsu pääsy
     "{$a->coursefullname}" kuin "{$a->rolename}" on tarkoitettu {$a->email}.
     Jos et ole aiottua vastaanottaja, älä hyväksy tätä kutsua.</p>';
$string['invitationacceptancebutton'] = 'Hyväksy kutsu';

// Invite history strings.
$string['invitehistory'] = 'Kutsu historia';
$string['noinvitehistory'] = 'Ei kutsuja lähetettiin vielä';
$string['historyinvitee'] = 'Kutsuttavan';
$string['historyrole'] = 'Rooli';
$string['historystatus'] = 'Tila';
$string['historydatesent'] = 'Lähetyspäivä';
$string['historydateexpiration'] = 'Viimeinen käyttöpäivä';
$string['historyactions'] = 'Toiminnot';
$string['historyundefinedrole'] = 'Ei löydy rooliin. Ole hyvä paheksua kutsua ja valitse toinen asema.';
$string['historyexpires_in'] = 'vanhenee';
$string['used_by'] = 'kautta {$a->username} ({$a->roles}, {$a->useremail}) aikana {$a->timeused}';

// Invite status strings.
$string['status_invite_invalid'] = 'Pätemätön';
$string['status_invite_expired'] = 'Vanhentunut';
$string['status_invite_used'] = 'Hyväksytyt';
$string['status_invite_used_noaccess'] = '(ei ole enää pääsyä)';
$string['status_invite_used_expiration'] = '(pääsy päättyy {$a})';
$string['status_invite_revoked'] = 'Kumottu';
$string['status_invite_resent'] = 'Lähetetty uudelleen';
$string['status_invite_active'] = 'Aktiivinen';

// Invite action strings.
$string['action_revoke_invite'] = 'Kumota kutsua';
$string['action_extend_invite'] = 'Pidentää kutsua';
$string['action_resend_invite'] = 'Lähetä uudelleen kutsua';

// Capabilities strings.
$string['invitation:config'] = 'Määritä kutsu tapauksia';
$string['invitation:enrol'] = 'IKutsu käyttäjiä';
$string['invitation:manage'] = 'Hallitse kutsu toimeksiannot';
$string['invitation:unenrol'] = 'Määrittelemätön käyttäjiä kurssin';
$string['invitation:unenrolself'] = 'Määrittelemätön itse kurssin';

// Strings for datetimehelpers.
$string['less_than_x_seconds'] = 'alle {$a} sekunnissa';
$string['half_minute'] = 'puoli minuuttia';
$string['less_minute'] = 'alle minuutti';
$string['a_minute'] = '1 minuutti';
$string['x_minutes'] = '{$a} minuuttia';
$string['about_hour'] = 'noin 1 tunti';
$string['about_x_hours'] = 'noin {$a} tuntia';
$string['a_day'] = '1 päivä';
$string['x_days'] = '{$a} päivää';