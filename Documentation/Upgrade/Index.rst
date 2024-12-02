..  include:: /Includes.rst.txt

..  _upgrade:

=======================
Upgrade from 1.x to 2.x
=======================


Breaking changes
================


Library updates
---------------

The library ``steverhoades/oauth2-openid-connect-server`` has been updated to version ``3.*``.


Replaced hook by PSR-14 event
-----------------------------

The hook ``$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['oidc_server']['domain/model/user/modify-claims']`` has been removed.
Use the PSR-14 event ``ModifyUserClaimsEvent`` instead.
