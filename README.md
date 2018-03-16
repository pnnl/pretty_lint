Pretty Linter
================
Pretty lint JSON and YAML files

How it works
----------------
It uses the existing JSON and YAML linters provided by GrumPHP.
If using this the `jsonlint` and `yamllint` tasks are not necessary.

Keeps objects in JSON and YAML files alphabetically sorted.
This helps prevent cases where the text of files appear to be completely replaced when sorting changes.

Keys you want to keep at the top of a file (like `name` and `description` in a `composer.json` file)
can be placed in the `top_keys` configuration to keep them at the top of their parent object.

How to use:
----------------
Add the package to your `composer.json` file:
```shell
composer require --dev pnnl/pretty_lint
```

Add the extension to your `grumphp.yml` file:
```yaml
#grumphp.yml
parameters:
  extensions:
    - Pnnl\PrettyJSONYAML\Extension\Loader
```

Add and configure the tasks as defined below in the "Parameters" section.

Parameters:
----------------
```yaml
#grumphp.yml
parameters:
  tasks:
    prettyjson:
      auto_fix: true
      indent: 2
      top_keys: []
      ignore_patterns: []
      detect_key_conflicts: false
    prettyyaml:
      auto_fix: true
      indent: 2
      top_keys: []
      ignore_patterns: []
      object_support: false
      exception_on_invalid_type: false
      parse_constant: false
      parse_custom_tags: false

```
**auto_fix**

*Default: true*

This option determines if the detected order errors should be fixed automatically.

**indent**

*Default: 2*

Number of spaces to indent the file when auto-fixing errors.

**top_keys**

*Default: []*

This option determines what keys should be at the top of an object instead of alphabetical.

**Other parameters**
See [`jsonlint`](https://github.com/phpro/grumphp/blob/master/doc/tasks/jsonlint.md) 
for `ignore_patterns`, `detect_key_conflicts` documentation.

See [`yamllint`](https://github.com/phpro/grumphp/blob/master/doc/tasks/yamllint.md) 
for `ignore_patterns`, `object_support`, `exception_on_invalid_type`, `parse_constant`, and `parse_custom_tags` documentation.

To Do
----------------
* Add ability to specify global and per-file top-keys
