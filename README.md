# Aura Suite Plugin for Grav CMS

**Aura Suite** is an advanced evolution of the original [Aura Authors](https://github.com/matt-j-m/grav-plugin-aura-authors) plugin for **Grav CMS**.

Built natively for **PHP 8** and **Grav 2.0+**, the plugin centralizes author profiles and automatically injects author bio blocks and structured data optimized for search engines.

---

## 🚀 Key Features

* **Backward Compatible**: Full support for legacy *Aura Authors* YAML configurations alongside modern Grav 2.0 / PHP 8 architecture.
* **Centralized Author Management**: Easily configure author profiles via the Admin panel or direct YAML editing (`user/config/plugins/aura-suite.yaml`).
* **Automatic Taxonomy Syncing**: Seamlessly maps the selected author to Grav's `author` taxonomy upon saving pages.
* **Structured Data (SEO / JSON-LD)**: Automatically generates Schema.org markup (`Article` / `WebSite`) ready for search engines.
* **Dynamic Bio Injection**: Automatically appends customizable author bio templates to page content.
* **Grav 2.0 & Flex Objects Native**: Utilizes `config-options@` binding for maximum responsiveness in the Admin panel.

---

## 📦 Installation

### Via Git (Recommended)

Navigate to your Grav installation's plugin directory and clone the repository:

```bash
cd user/plugins
git clone [https://github.com/oldstonegryzzly/aura-suite.git](https://github.com/oldstonegryzzly/aura-suite.git) aura-suite
```
### Manual Installation
Download the ZIP package from the repository.

Extract the contents into user/plugins/aura-suite.

Clear the Grav cache:

```bash
bin/grav clear-site-cache
```
## ⚙️ Configuration

Create or edit the configuration file at user/config/plugins/aura-suite.yaml:

```bash
enabled: true
auto_append_author: true
```
## 🔄 Backward Compatibility & Migration

**Aura Suite** is designed to be a drop-in replacement for the original `aura-authors` plugin. 

To migrate from **Aura Authors** to **Aura Suite**, you simply need to copy your existing configuration file:

```bash
cp user/config/plugins/aura-authors.yaml user/config/plugins/aura-suite.yaml
```
* **Important Step:** Log in to the Grav Admin panel, open the Aura Suite plugin settings, and click Save at least once.

Note: Saving the configuration triggers the automatic generation of `authors_list` (required for dropdown selection in page blueprints). After this single save, all existing profiles, descriptions, and custom fields will be fully functional across your site.


## 👨‍💻 Credits & Acknowledgments
Original Plugin & Concept: Based on grav-plugin-aura-authors created by Matt J M (@matt-j-m).

Aura Suite Evolution & Maintenance: OldstoneGryzzly (@oldstonegryzzly).

Environment: Developed on Linux (Kubuntu / KDE Plasma) for Grav CMS.

## 📄 License
This project is licensed under the MIT License. See the LICENSE file for details.
