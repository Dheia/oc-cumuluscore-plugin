# Cumulus Core

# Introduction
The plugin is a skeleton for building Software as a Service (SaaS) applications using OctoberCMS. Software as a Service application is (according to Wikipedia) a software licensing and delivery model in which software is licensed on a subscription basis and is centrally hosted.

The easiest way to understand it is to imagine an application which you want to create for your clients (one application for more than one client) but it is going to be hosted on your server.

Here are some examples of use cases where Cumulus may help:
* system for your clients' companies where they can have their private data in cloud while other clients cannot see each other's data like invoicing system, client management system etc.
* system for schools where classes can share some data and have access to some data while cannot see other classes data like exams system, school diary etc.
* every system that supports cutting functionality for different plans (like "Free", "Plus", "Pro") like in the example below:
![Pricing table example](https://github.com/initbizlab/oc-cumuluscore-plugin/raw/features/docs/images/pricing-table.png)


## TL;DR
If you just want to see what Cumulus can do for you, great place to start will be:
1. installing official [Cumulus theme](https://octobercms.com/theme/initbiz-cumulus)
1. running `php artisan cumulus:seed` command (see [Cumulus Demo](https://octobercms.com/plugin/initbiz-cumulusdemo) documentation for info about the command)

After that you are ready to play with Cumulus based app with demo data seeded (user demo@example.com with password demo):)

See documentation for more about Cumulus using and configuration.

## CumulusCore extensions
**[Cumulus Subscriptions](https://octobercms.com/plugin/initbiz-cumulussubscriptions)**
![Cumulus Subscriptions Icon](https://octobercms.com/storage/app/uploads/public/5bb/cc6/83e/thumb_11218_64_64_0_0_auto.png)

Extend your Cumulus Core system with automatic subscription manager.

**[Cumulus Plus](https://octobercms.com/plugin/initbiz-cumulusplus)**
![Cumulus Plus Icon](https://octobercms.com/storage/app/uploads/public/5b2/a0e/2d7/thumb_10080_64_64_0_0_auto.png)

Extend your Cumulus Core system with dashboard and settings pages within seconds.

**[Cumulus Announcements](https://octobercms.com/plugin/initbiz-cumulusannouncements)**
![Cumulus Announcements Icon](https://octobercms.com/storage/app/uploads/public/5b0/ed4/66c/thumb_9923_64_64_0_0_auto.png)

Notify users of your system about things that concerns them, their clusters or their plans.

## Other products using Cumulus Core

**[Cumulus Theme](https://octobercms.com/theme/initbiz-cumulus)**

Using the theme you can install bare Cumulus application with a single click of a mouse. This is only a suggestion, scheme. Cumulus does not require this theme. It is fully up to you how you decide to use it.

**[Power Components](https://octobercms.com/theme/initbiz-powercomponents)**
![Power Components icon](https://octobercms.com/storage/app/uploads/public/5af/b1c/992/thumb_9851_64_64_0_0_auto.png)

Power Components plugin integrates with Cumulus Core so that lists and forms generated by it can be easily filtered and accessible only for particular cluster.

# Documentation

## Terms used in Cumulus and this document
**User** is a frontend user from `RainLab.User` plugin who can log to frontend. See [RainLab.User documentation](https://octobercms.com/plugin/rainlab-user) for more info about this.

**Cluster** is a group of users which share some data between them and can be described as one entity. The most common example is a company. But it also applies to offices, office branches, classes in school, schools etc. Cluster is not a usergroup from RainLab.User plugin (like guest, registered and so on). User groups are about permissions (like read, write, update etc.) while clusters are about organizing users in logical entities.

**Plan**s are assigned to clusters. Cluster can have only one plan at a time. Imagine a pricing table like in the example below. So plans here are "Free", "Plus", "Pro".

![Pricing table example](https://github.com/initbizlab/oc-cumuluscore-plugin/raw/features/docs/images/pricing-table.png)

**Feature** is a part of functionality of application. The easiest explanation of features is the records in the above table. Features are registered by your plugins as described below. It is fully up to you to create functionality of your application.

## Concept
In all SaaS applications there are at least two groups of pages:
1. Those which are publicly visible (where you put your offer, regulations, contact form, login form, register form etc.),
1. Those accessible only for registered users and logged in users.

In Cumulus we extend the second group of pages so that you may have also pages that are accessible only for users that are:
1. logged in and nothing more (like manage profile page or some kind of dashboard),
1. assigned to a group of users (called cluster here) and are restricted only for particular cluster (for example cluster's dashboard with data that can be visible for all users in the cluster),
1. assigned to a cluster and their cluster has access to particular feature (for example one cluster has access to pages related with invoicing and the other does not).

Check the How to section to see how it may be done.

## Separated frontend and backend user access
It may be difficult to understand the difference between frontend and backend users at first glance.

By design backend admin is a developer like me and you while frontend (Cumulus) user is your client. Your clients are using your application but they must not see other clients' data (of course if you want to) and you, as backend admin, have access to all data of your clients. So as you can see here those are two completely different points of view on the application.

## Features
Cumulus is using features to separate functionality and access for front-end users. Every plugin can register it's own features using `registerCumulusFeatures` method in plugin registration file.

The syntax is similar to registering backend permissions, so you may be familiar with.

For example:

```php
    public function registerCumulusFeatures()
    {
        return [
           'initbiz.cumulusinvoices.manage_invoices' => [
               'label' => 'initbiz.cumulusinvoices::lang.feature.manage_invoices',
               'description' => 'initbiz.cumulusinvoices::lang.feature.manage_invoices_desc',
               'tab' => 'initbiz.cumulusinvoices::lang.feature.invoices_tab',
           ]
        ];
    }
```

Features are assigned to plans. So that every cluster that has particular plan has the same set of features.

It is up to you while writing plugin how many features will it register for our clients. There must be a reasonable amount of them for us to easily manage which features should be applied to which plan.

Before creating and using features read about `FeatureGuard` component below.

## How-to

### Shortcut
If you want to play with working Cumulus environment then install clean OctoberCMS using [Cumulus theme](https://octobercms.com/theme/initbiz-cumulus) and run `php artisan cumulus:seed` command.

This will prepare very basic environment. More info about the process can be found in [Cumulus Demo](https://octobercms.com/plugin/initbiz-cumulusdemo) docs.

### Full way
As defined in **Concept** section above, pages in Cumulus based applications are in one of four groups. In Cumulus we use October's components to create page (or layout) as one of the group.

* public pages do not require special configuration
* pages that require user to be logged in should use `Session` component from `RainLab.User`
* pages that require user to be assigned to particular cluster should use `CumulusGuard` component
* pages that require current cluster to have access to particular feature should use `FeatureGuard` component

If you want to check if user is signed in, is assigned to a cluster and the cluster has access to a feature, then embed all three components (`Session`, `CumulusGuard` and `FeatureGuard`).

The cleanest way will be creating layouts with sets of component configurations instead of embedding them on every page.

> More information about the components can be found below.

Example usage for our client will be as follows:
1. User visits login page and after successful logging in he/she will be redirected to "Choose cluster" page (screenshot below)
1. After he/she chooses cluster he/she will be redirected to the cluster's dashboard.

On "Choose cluster" page will be `UserClustersList` component embedded which automatically redirects user to cluster's dashboard if he/she is assigned to only one cluster.

### Login page
Login page can use `Account` component from `RainLab.Users` plugin. It should be configured so that it automatically redirects to "Choose cluster" page after successful logging in.

![Login page](https://github.com/initbizlab/oc-cumuluscore-plugin/raw/features/docs/images/login-page.png)

### "Choose cluster" page
On "Choose cluster" page should be `UserClustersList` component embedded. It will automatically redirect user to cluster's dashboard if he/she is assigned to only one cluster.

![Choose cluster page](https://github.com/initbizlab/oc-cumuluscore-plugin/raw/features/docs/images/choose-cluster-page.png)

### Cluster's dashboard
Welcome screen for everyone in the cluster.

![Cluster's dashboard page](https://github.com/initbizlab/oc-cumuluscore-plugin/raw/features/docs/images/cluster-dashboard-page.png)

From this level every page url should contain cluster slug variable. By default it is `:cluster` but it can be changed in component. So from now all pages will have url similar to this:

![Cluster's dashboard page view](https://github.com/initbizlab/oc-cumuluscore-plugin/raw/features/docs/images/cluster-dashboard-page-view.png)

### Feature pages
Every page of your system that provides some functionality is considered as "Feature page". So here is where Cumulus cannot help anymore (and tries to not disturb you with unnecessary code bloat).

### Components

**UserClustersList**

The components role is to render view to select cluster if user is assigned to more than one cluster.

> Note: If user is assigned to one cluster then the component will automatically redirect to `Cluster dashboard page`

![Clusters list component](https://github.com/initbizlab/oc-cumuluscore-plugin/raw/features/docs/images/user-cluster-list-component.png)

**CumulusGuard**

The `CumulusGuard` component is here to check if the logged in user has access to cluster that he/she tries to visit. It uses cluster slug from url.

What is more, the component pushes two variables to view:
* `cluster` which contains current cluster's slug
* `clusterData ` which contains array of the current cluster data.

and sets active cluster's slug in session variable and cookie as `cumulus_clusterslug`.

**FeatureGuard**
Feature guard is a component which ensures if current cluster can see the page based on features it has access to.

**Remember that only one of checked features is enough to let the user see the page**

![Feature guard](https://github.com/initbizlab/oc-cumuluscore-plugin/raw/features/docs/images/feature-guard.png)

> If you want to filter content on one page so that only a cluster that has access to this and that feature can see this use `canEnterFeature` twig function described below.

### Repositories
In Cumulus we decided to use repositories to access data from DB.

That is because we had problems with models using models using models (this inception O.o) and problems with organization of useful methods. Of course under the hood there are typical Eloquent models, so if you want to use them go ahead.

To use clusterRepository you have to create the object as in the example below:
```php
    use Initbiz\CumulusCore\Repositories\ClusterRepository;
    ...
    $clusterSlug = $this->property('clusterSlug');
    $clusterRepository = new ClusterRepository($clusterSlug);
    $clusterData = $clusterRepository->getCurrentCluster();
```

**ClusterRepository**

`canEnterCluster(int $userId, string $clusterSlug)` - check if user can enter given cluster

`canEnterFeature(string $clusterSlug, string $featureCode)` - check if cluster can enter the feature (using its plan)

`getClustersUsers(array $clustersSlugs)` - get array of users in given clusters array (can be more than one)

`getClusterFeatures(string $clusterSlug)` - get array of cluster's features

`addUserToCluster(int $userId, string $clusterSlug)` - adds user to cluster

`addClusterToPlan(string $clusterSlug, string $planSlug)` - assigns a plan to cluster

`getClustersPlans(array $clustersSlugs)` - get array of clusters that has given plans (can be more than one)

**PlanRepository**

`getPlansUsers(array $plansSlugs)` - the method takes array of plans slugs and get all users that are in those plans.

**UserRepository**

`addUserToGroup($userId, $groupCode)` - adds user to group (`RainLab.UserGroup`)

`activateUser($userId)` - activate user (by default users are not active)

## Helpers
//TODO:

## Auto assign
Auto assigning is Cumulus functionality that automatically assigns users and clusters during their registering. You can create a lot of configurations.

Go to Settings -> Cumulus -> Auto assign. You wil find there two tabs: "Auto assign users" and "Auto assign clusters".

### Auto assign users

![Auto assign users](https://github.com/initbizlab/oc-cumuluscore-plugin/raw/features/docs/images/auto-assign-users.png)

While auto assigning users to clusters you can decide if you want to:
* create new cluster using variable specified in "variable name" (for example company name)
* choose existing cluster for every newly registered user
* get cluster slug from variable

You can also decide whether you want to add user to a group after registering or not (`RainLab.UserGroup`).


### Auto assign clusters

![Auto assign clusters](https://github.com/initbizlab/oc-cumuluscore-plugin/raw/features/docs/images/auto-assign-clusters.png)

## `ClusterFiltrable` trait
The `ClusterFiltrable` trait is meant to be used in models.

```php
    class Course extends Model
    {
        use \Initbiz\CumulusCore\Traits\ClusterFiltrable;
        ...
    }
```

//TODO:
After that you can use `clusterFiltered()` method on model to filter the data using currently picked cluster (it's slug).

//TODO:
It also adds `clusterUnique($attribute, $table = null, $columnName = 'cluster_slug')`

## Twig extensions
### `canEnterFeature('feature.code')`
//TODO:
If you want to check in twig if current cluster has access to "feature.code" than use `canEnterFeature('feature.code')` Twig function.

```twig

```

## Rainlab.User note
The plugin extends RainLab.User plugin and uses the same `User` model, so if you want to restrict backend admin to manage users remember that there is controller from RainLab.Users that uses the same Model and can access the same data.

## Menus / Navigation
Cumulus extends [RainLab.Pages](https://octobercms.com/plugin/rainlab-pages) plugin as well. It uses only one part of static pages plugin: building menus.

Cumulus adds possibility to add pages to menus which are filtered using clusters, so that clusters will see only those menu items that they are permitted to see using features.

## Cumulus Core events

//TODO:
## Troubleshooting

### I cannot see my registered features
If you cannot see your features then go to Settings -> Cumulus -> Features and click `Clear feature cache` button.


## Future plans (TODO)
//TODO:
* Automatically build features table
