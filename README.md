# Aura Suite Plugin per Grav CMS

**Aura Suite** è un plugin avanzato per **Grav CMS** sviluppato per la gestione semplificata e strutturata dei metadati dell'autore, della tassonomia e del mark-up semantico JSON-LD (Schema.org).

Progettato con un'architettura nativa per **PHP 8** e **Grav 2.0+ (Flex Objects)**, il plugin permette di centrale la gestione degli autori e di iniettare in modo automatico i blocchi bio e i dati strutturati per i motori di ricerca.

---

## 🚀 Caratteristiche Principali

* **Gestione Centralizzata Autori**: Configurazione semplice da pannello Admin o via file YAML (`user/config/plugins/aura-suite.yaml`).
* **Sincronizzazione Automatica Tassonomie**: Mappatura trasparente tra l'autore selezionato e la tassonomia `author` di Grav al momento del salvataggio.
* **Integrazione Dati Strutturati (SEO/JSON-LD)**: Generazione automatica di Schema.org (`Article` / `WebSite`) pronto per i motori di ricerca.
* **Iniezione Bio Dinamica**: Inserimento automatico del template di bio dell'autore in coda ai contenuti delle pagine.
* **Compatibile con Grav 2.0 & Flex Objects**: Utilizzo del binding nativo `config-options@` per la massima reattività nell'Admin.

---

## 📦 Installazione

### Tramite Git (Consigliato)

Spostati nella cartella dei plugin del tuo sito Grav e clona il repository:

```bash
cd user/plugins
git clone [https://github.com/oldstonegryzzly/aura-suite.git](https://github.com/oldstonegryzzly/aura-suite.git) aura-suite
