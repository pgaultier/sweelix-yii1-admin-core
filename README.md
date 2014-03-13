Sweelix Yii CMS Core admin
==========================

Sweelix Yii CMS Core admin for Yii 1.1 is the foundation of the basic Sweelix backoffice.

Installation
------------

If you use Packagist for installing packages, then you can update your composer.json like this :

``` json
{
	"require": {
		"sweelix/yii1-admin-core": "*"
	}
}
```

The Core Admin is useless alone. It must be used with (sub)backoffice modules :

* sweelix/yii1-admin-dashboard : Basic dashboard
* sweelix/yii1-admin-structure : Basic content management (Nodes and Contents)
* sweelix/yii1-admin-cloud : Basic content tagging (Groups and Tags)
* sweelix/yii1-admin-users : Basic users management


Contributing
------------

All code contributions - including those of people having commit access -
must go through a pull request and approved by a core developer before being
merged. This is to ensure proper review of all the code.

Fork the project, create a [feature branch ](http://nvie.com/posts/a-successful-git-branching-model/), and send us a pull request.

