====== ICodeWP ======

* Check symfony/php components to use.
* For field definitions:
  * Create a FieldDefinition class (instead of array as field definition).
  * Create interfaces for: FieldDefinition and FieldDefinitionResolver.
  * Prefer the names FieldConfiguration and FieldConfigurationResolver instead?
  * Or FieldOptions and FieldOptionsResolver?
  * Use the OptionsResolver component from symfony?
  * Ability to have dynamic definitions? Or to update the definitions on the fly (eg: depending on the current post)?
  * Be able to automatically display the fields (with a 'place' def, or 'metabox' def, or...)
* Rename Entity into EntityManager.
* Create a manager of EntityManager.
  * Eg: a EntityManagers class,
  * a kind of container for all the EntityManager
  * allowing to pick up the good one, according to: an entity, or a type + name (eg: 'taxonomy', 'DocumentFormat'), etc.
* An EntityManager has:
  * init() process: init the vital things, at the very beginning of WP init.
  * load() process: is lazy-loaded (eg: loaded only if the entity is actually used).
  * erase() process, eg for a plugin uninstallation.
  * first_init() process, eg for a plugin installation.
* Extract the Controller from the EntityManager?
* Implement / use a true DIC.
* Classes should not depend on the container.
* Be able to check the Field configuration. Eg: if a 'max' conf must be an integer, check that.\
  (with symfony OptionsResolver).