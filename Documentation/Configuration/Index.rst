..  include:: /Includes.rst.txt

..  _configuration:

=============
Configuration
=============

..  seealso::

    Read the the :ref:`"Configuration" guide from EXT:oauth2_server <r3h6/oauth2-server:configuration>`.

..  confval:: claimSets
    :name: oidc-claimSets
    :type: object
    :required: false
    :Path: Site settings :yaml:`oauth2_server.claimSets`

    Define custom claim sets.
    An example integration is the role claim set of this extension to work with the `EXT:oidc <https://extensions.typo3.org/extension/oidc>`__ together.

    ..  code-block:: yaml

        oauth2:
            # Define custom claim sets
            claimSets:
                # Scope
                role:
                # Claims
                - Roles
