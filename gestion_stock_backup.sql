--
-- PostgreSQL database dump
--

\restrict Zk85swngZ8MITWN5f4wHAxqzhvbtQbNKf5dvvy5AJZRq0Xlmia7tMctFFK6KEf7

-- Dumped from database version 18.3
-- Dumped by pg_dump version 18.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: banques; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.banques (
    id bigint NOT NULL,
    tenant_id bigint NOT NULL,
    nom character varying(255) NOT NULL,
    numero_compte character varying(255),
    solde numeric(15,2) DEFAULT '0'::numeric NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.banques OWNER TO postgres;

--
-- Name: banques_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.banques_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.banques_id_seq OWNER TO postgres;

--
-- Name: banques_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.banques_id_seq OWNED BY public.banques.id;


--
-- Name: bons_commande_fournisseur; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bons_commande_fournisseur (
    id bigint NOT NULL,
    tenant_id bigint NOT NULL,
    fournisseur_id bigint NOT NULL,
    user_id bigint NOT NULL,
    numero character varying(255) NOT NULL,
    date_commande date NOT NULL,
    date_livraison_prevue date,
    statut character varying(255) DEFAULT 'en_attente'::character varying NOT NULL,
    montant_total numeric(15,2) DEFAULT '0'::numeric NOT NULL,
    notes text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT bons_commande_fournisseur_statut_check CHECK (((statut)::text = ANY ((ARRAY['en_attente'::character varying, 'reçu'::character varying, 'partiel'::character varying, 'annulé'::character varying])::text[])))
);


ALTER TABLE public.bons_commande_fournisseur OWNER TO postgres;

--
-- Name: bons_commande_fournisseur_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.bons_commande_fournisseur_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.bons_commande_fournisseur_id_seq OWNER TO postgres;

--
-- Name: bons_commande_fournisseur_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.bons_commande_fournisseur_id_seq OWNED BY public.bons_commande_fournisseur.id;


--
-- Name: bons_entree; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bons_entree (
    id bigint NOT NULL,
    tenant_id bigint NOT NULL,
    user_id bigint NOT NULL,
    numero character varying(255) NOT NULL,
    type character varying(255) NOT NULL,
    date_entree date NOT NULL,
    source character varying(255),
    notes text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT bons_entree_type_check CHECK (((type)::text = ANY ((ARRAY['don'::character varying, 'retour'::character varying, 'ajustement'::character varying, 'autre'::character varying])::text[])))
);


ALTER TABLE public.bons_entree OWNER TO postgres;

--
-- Name: bons_entree_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.bons_entree_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.bons_entree_id_seq OWNER TO postgres;

--
-- Name: bons_entree_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.bons_entree_id_seq OWNED BY public.bons_entree.id;


--
-- Name: bons_sortie; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.bons_sortie (
    id bigint NOT NULL,
    tenant_id bigint NOT NULL,
    user_id bigint NOT NULL,
    numero character varying(255) NOT NULL,
    motif character varying(255) NOT NULL,
    date_sortie date NOT NULL,
    notes text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT bons_sortie_motif_check CHECK (((motif)::text = ANY ((ARRAY['périmé'::character varying, 'non_vendu'::character varying, 'casse'::character varying, 'autre'::character varying])::text[])))
);


ALTER TABLE public.bons_sortie OWNER TO postgres;

--
-- Name: bons_sortie_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.bons_sortie_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.bons_sortie_id_seq OWNER TO postgres;

--
-- Name: bons_sortie_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.bons_sortie_id_seq OWNED BY public.bons_sortie.id;


--
-- Name: cache; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO postgres;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO postgres;

--
-- Name: categories_clients; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.categories_clients (
    id bigint NOT NULL,
    tenant_id bigint NOT NULL,
    nom character varying(255) NOT NULL,
    remise_default numeric(5,2) DEFAULT '0'::numeric NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.categories_clients OWNER TO postgres;

--
-- Name: categories_clients_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.categories_clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categories_clients_id_seq OWNER TO postgres;

--
-- Name: categories_clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.categories_clients_id_seq OWNED BY public.categories_clients.id;


--
-- Name: clients; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.clients (
    id bigint NOT NULL,
    tenant_id bigint NOT NULL,
    categorie_id bigint NOT NULL,
    nom character varying(255) NOT NULL,
    telephone character varying(255),
    email character varying(255),
    adresse character varying(255),
    solde numeric(15,2) DEFAULT '0'::numeric NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.clients OWNER TO postgres;

--
-- Name: clients_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.clients_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.clients_id_seq OWNER TO postgres;

--
-- Name: clients_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.clients_id_seq OWNED BY public.clients.id;


--
-- Name: commandes_client; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.commandes_client (
    id bigint NOT NULL,
    tenant_id bigint NOT NULL,
    client_id bigint NOT NULL,
    user_id bigint NOT NULL,
    numero character varying(255) NOT NULL,
    date_commande date NOT NULL,
    statut character varying(255) DEFAULT 'en_attente'::character varying NOT NULL,
    montant_total numeric(15,2) DEFAULT '0'::numeric NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT commandes_client_statut_check CHECK (((statut)::text = ANY ((ARRAY['en_attente'::character varying, 'livrée'::character varying, 'partielle'::character varying, 'annulée'::character varying])::text[])))
);


ALTER TABLE public.commandes_client OWNER TO postgres;

--
-- Name: commandes_client_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.commandes_client_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.commandes_client_id_seq OWNER TO postgres;

--
-- Name: commandes_client_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.commandes_client_id_seq OWNED BY public.commandes_client.id;


--
-- Name: factures_client; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.factures_client (
    id bigint NOT NULL,
    tenant_id bigint NOT NULL,
    commande_id bigint,
    client_id bigint NOT NULL,
    user_id bigint NOT NULL,
    numero character varying(255) NOT NULL,
    date_facture date NOT NULL,
    montant_ht numeric(15,2) NOT NULL,
    tva numeric(5,2) DEFAULT '0'::numeric NOT NULL,
    montant_ttc numeric(15,2) NOT NULL,
    montant_regle numeric(15,2) DEFAULT '0'::numeric NOT NULL,
    statut character varying(255) DEFAULT 'impayée'::character varying NOT NULL,
    type_vente character varying(255) DEFAULT 'crédit'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT factures_client_statut_check CHECK (((statut)::text = ANY ((ARRAY['impayée'::character varying, 'partielle'::character varying, 'réglée'::character varying])::text[]))),
    CONSTRAINT factures_client_type_vente_check CHECK (((type_vente)::text = ANY ((ARRAY['crédit'::character varying, 'comptant'::character varying])::text[])))
);


ALTER TABLE public.factures_client OWNER TO postgres;

--
-- Name: factures_client_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.factures_client_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.factures_client_id_seq OWNER TO postgres;

--
-- Name: factures_client_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.factures_client_id_seq OWNED BY public.factures_client.id;


--
-- Name: factures_fournisseur; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.factures_fournisseur (
    id bigint NOT NULL,
    tenant_id bigint NOT NULL,
    bon_commande_id bigint,
    fournisseur_id bigint NOT NULL,
    user_id bigint NOT NULL,
    numero character varying(255) NOT NULL,
    date_facture date NOT NULL,
    date_echeance date,
    montant_ht numeric(15,2) NOT NULL,
    tva numeric(5,2) DEFAULT '0'::numeric NOT NULL,
    montant_ttc numeric(15,2) NOT NULL,
    montant_regle numeric(15,2) DEFAULT '0'::numeric NOT NULL,
    statut character varying(255) DEFAULT 'impayée'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT factures_fournisseur_statut_check CHECK (((statut)::text = ANY ((ARRAY['impayée'::character varying, 'partielle'::character varying, 'réglée'::character varying])::text[])))
);


ALTER TABLE public.factures_fournisseur OWNER TO postgres;

--
-- Name: factures_fournisseur_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.factures_fournisseur_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.factures_fournisseur_id_seq OWNER TO postgres;

--
-- Name: factures_fournisseur_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.factures_fournisseur_id_seq OWNED BY public.factures_fournisseur.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO postgres;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: familles_produits; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.familles_produits (
    id bigint NOT NULL,
    tenant_id bigint NOT NULL,
    nom character varying(255) NOT NULL,
    description character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.familles_produits OWNER TO postgres;

--
-- Name: familles_produits_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.familles_produits_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.familles_produits_id_seq OWNER TO postgres;

--
-- Name: familles_produits_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.familles_produits_id_seq OWNED BY public.familles_produits.id;


--
-- Name: fournisseurs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.fournisseurs (
    id bigint NOT NULL,
    tenant_id bigint NOT NULL,
    nom character varying(255) NOT NULL,
    telephone character varying(255),
    email character varying(255),
    adresse character varying(255),
    numero_contribuable character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.fournisseurs OWNER TO postgres;

--
-- Name: fournisseurs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.fournisseurs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.fournisseurs_id_seq OWNER TO postgres;

--
-- Name: fournisseurs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.fournisseurs_id_seq OWNED BY public.fournisseurs.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.job_batches (
    id character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    total_jobs integer NOT NULL,
    pending_jobs integer NOT NULL,
    failed_jobs integer NOT NULL,
    failed_job_ids text NOT NULL,
    options text,
    cancelled_at integer,
    created_at integer NOT NULL,
    finished_at integer
);


ALTER TABLE public.job_batches OWNER TO postgres;

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO postgres;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: lignes_bon_entree; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.lignes_bon_entree (
    id bigint NOT NULL,
    bon_entree_id bigint NOT NULL,
    produit_id bigint NOT NULL,
    quantite integer NOT NULL,
    valeur_unitaire numeric(15,2) DEFAULT '0'::numeric NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.lignes_bon_entree OWNER TO postgres;

--
-- Name: lignes_bon_entree_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.lignes_bon_entree_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.lignes_bon_entree_id_seq OWNER TO postgres;

--
-- Name: lignes_bon_entree_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.lignes_bon_entree_id_seq OWNED BY public.lignes_bon_entree.id;


--
-- Name: lignes_bon_sortie; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.lignes_bon_sortie (
    id bigint NOT NULL,
    bon_sortie_id bigint NOT NULL,
    produit_id bigint NOT NULL,
    quantite integer NOT NULL,
    valeur_unitaire numeric(15,2) DEFAULT '0'::numeric NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.lignes_bon_sortie OWNER TO postgres;

--
-- Name: lignes_bon_sortie_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.lignes_bon_sortie_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.lignes_bon_sortie_id_seq OWNER TO postgres;

--
-- Name: lignes_bon_sortie_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.lignes_bon_sortie_id_seq OWNED BY public.lignes_bon_sortie.id;


--
-- Name: lignes_commande_client; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.lignes_commande_client (
    id bigint NOT NULL,
    commande_id bigint NOT NULL,
    produit_id bigint NOT NULL,
    quantite integer NOT NULL,
    prix_unitaire numeric(15,2) NOT NULL,
    remise numeric(5,2) DEFAULT '0'::numeric NOT NULL,
    montant numeric(15,2) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.lignes_commande_client OWNER TO postgres;

--
-- Name: lignes_commande_client_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.lignes_commande_client_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.lignes_commande_client_id_seq OWNER TO postgres;

--
-- Name: lignes_commande_client_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.lignes_commande_client_id_seq OWNED BY public.lignes_commande_client.id;


--
-- Name: lignes_commande_fournisseur; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.lignes_commande_fournisseur (
    id bigint NOT NULL,
    bon_commande_id bigint NOT NULL,
    produit_id bigint NOT NULL,
    quantite_commandee integer NOT NULL,
    quantite_recue integer DEFAULT 0 NOT NULL,
    prix_unitaire numeric(15,2) NOT NULL,
    montant numeric(15,2) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.lignes_commande_fournisseur OWNER TO postgres;

--
-- Name: lignes_commande_fournisseur_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.lignes_commande_fournisseur_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.lignes_commande_fournisseur_id_seq OWNER TO postgres;

--
-- Name: lignes_commande_fournisseur_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.lignes_commande_fournisseur_id_seq OWNED BY public.lignes_commande_fournisseur.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO postgres;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: model_has_permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.model_has_permissions (
    permission_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);


ALTER TABLE public.model_has_permissions OWNER TO postgres;

--
-- Name: model_has_roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.model_has_roles (
    role_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);


ALTER TABLE public.model_has_roles OWNER TO postgres;

--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO postgres;

--
-- Name: permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.permissions (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.permissions OWNER TO postgres;

--
-- Name: permissions_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.permissions_id_seq OWNER TO postgres;

--
-- Name: permissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.permissions_id_seq OWNED BY public.permissions.id;


--
-- Name: produits; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.produits (
    id bigint NOT NULL,
    tenant_id bigint NOT NULL,
    famille_id bigint NOT NULL,
    produit_parent_id bigint,
    code character varying(255) NOT NULL,
    nom character varying(255) NOT NULL,
    unite character varying(255) NOT NULL,
    prix_achat numeric(15,2) DEFAULT '0'::numeric NOT NULL,
    prix_vente numeric(15,2) DEFAULT '0'::numeric NOT NULL,
    stock_actuel integer DEFAULT 0 NOT NULL,
    stock_minimum integer DEFAULT 0 NOT NULL,
    date_expiration date,
    type character varying(255) DEFAULT 'simple'::character varying NOT NULL,
    facteur_fraction numeric(10,4) DEFAULT '1'::numeric NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT produits_type_check CHECK (((type)::text = ANY ((ARRAY['simple'::character varying, 'père'::character varying, 'fils'::character varying])::text[])))
);


ALTER TABLE public.produits OWNER TO postgres;

--
-- Name: produits_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.produits_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.produits_id_seq OWNER TO postgres;

--
-- Name: produits_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.produits_id_seq OWNED BY public.produits.id;


--
-- Name: role_has_permissions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.role_has_permissions (
    permission_id bigint NOT NULL,
    role_id bigint NOT NULL
);


ALTER TABLE public.role_has_permissions OWNER TO postgres;

--
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.roles (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.roles OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.roles_id_seq OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO postgres;

--
-- Name: tenants; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.tenants (
    id bigint NOT NULL,
    nom_entreprise character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    telephone character varying(255),
    adresse character varying(255),
    statut character varying(255) DEFAULT 'actif'::character varying NOT NULL,
    date_expiration date,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT tenants_statut_check CHECK (((statut)::text = ANY ((ARRAY['actif'::character varying, 'suspendu'::character varying, 'expiré'::character varying])::text[])))
);


ALTER TABLE public.tenants OWNER TO postgres;

--
-- Name: tenants_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.tenants_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.tenants_id_seq OWNER TO postgres;

--
-- Name: tenants_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.tenants_id_seq OWNED BY public.tenants.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO postgres;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: versements_banque; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.versements_banque (
    id bigint NOT NULL,
    tenant_id bigint NOT NULL,
    banque_id bigint NOT NULL,
    user_id bigint NOT NULL,
    montant numeric(15,2) NOT NULL,
    date_versement date NOT NULL,
    reference character varying(255),
    notes text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.versements_banque OWNER TO postgres;

--
-- Name: versements_banque_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE public.versements_banque_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.versements_banque_id_seq OWNER TO postgres;

--
-- Name: versements_banque_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE public.versements_banque_id_seq OWNED BY public.versements_banque.id;


--
-- Name: banques id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.banques ALTER COLUMN id SET DEFAULT nextval('public.banques_id_seq'::regclass);


--
-- Name: bons_commande_fournisseur id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bons_commande_fournisseur ALTER COLUMN id SET DEFAULT nextval('public.bons_commande_fournisseur_id_seq'::regclass);


--
-- Name: bons_entree id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bons_entree ALTER COLUMN id SET DEFAULT nextval('public.bons_entree_id_seq'::regclass);


--
-- Name: bons_sortie id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bons_sortie ALTER COLUMN id SET DEFAULT nextval('public.bons_sortie_id_seq'::regclass);


--
-- Name: categories_clients id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories_clients ALTER COLUMN id SET DEFAULT nextval('public.categories_clients_id_seq'::regclass);


--
-- Name: clients id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients ALTER COLUMN id SET DEFAULT nextval('public.clients_id_seq'::regclass);


--
-- Name: commandes_client id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commandes_client ALTER COLUMN id SET DEFAULT nextval('public.commandes_client_id_seq'::regclass);


--
-- Name: factures_client id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.factures_client ALTER COLUMN id SET DEFAULT nextval('public.factures_client_id_seq'::regclass);


--
-- Name: factures_fournisseur id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.factures_fournisseur ALTER COLUMN id SET DEFAULT nextval('public.factures_fournisseur_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: familles_produits id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.familles_produits ALTER COLUMN id SET DEFAULT nextval('public.familles_produits_id_seq'::regclass);


--
-- Name: fournisseurs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fournisseurs ALTER COLUMN id SET DEFAULT nextval('public.fournisseurs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: lignes_bon_entree id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lignes_bon_entree ALTER COLUMN id SET DEFAULT nextval('public.lignes_bon_entree_id_seq'::regclass);


--
-- Name: lignes_bon_sortie id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lignes_bon_sortie ALTER COLUMN id SET DEFAULT nextval('public.lignes_bon_sortie_id_seq'::regclass);


--
-- Name: lignes_commande_client id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lignes_commande_client ALTER COLUMN id SET DEFAULT nextval('public.lignes_commande_client_id_seq'::regclass);


--
-- Name: lignes_commande_fournisseur id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lignes_commande_fournisseur ALTER COLUMN id SET DEFAULT nextval('public.lignes_commande_fournisseur_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: permissions id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions ALTER COLUMN id SET DEFAULT nextval('public.permissions_id_seq'::regclass);


--
-- Name: produits id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produits ALTER COLUMN id SET DEFAULT nextval('public.produits_id_seq'::regclass);


--
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- Name: tenants id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tenants ALTER COLUMN id SET DEFAULT nextval('public.tenants_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: versements_banque id; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.versements_banque ALTER COLUMN id SET DEFAULT nextval('public.versements_banque_id_seq'::regclass);


--
-- Data for Name: banques; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.banques (id, tenant_id, nom, numero_compte, solde, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: bons_commande_fournisseur; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.bons_commande_fournisseur (id, tenant_id, fournisseur_id, user_id, numero, date_commande, date_livraison_prevue, statut, montant_total, notes, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: bons_entree; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.bons_entree (id, tenant_id, user_id, numero, type, date_entree, source, notes, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: bons_sortie; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.bons_sortie (id, tenant_id, user_id, numero, motif, date_sortie, notes, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache (key, value, expiration) FROM stdin;
\.


--
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.cache_locks (key, owner, expiration) FROM stdin;
\.


--
-- Data for Name: categories_clients; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.categories_clients (id, tenant_id, nom, remise_default, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: clients; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.clients (id, tenant_id, categorie_id, nom, telephone, email, adresse, solde, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: commandes_client; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.commandes_client (id, tenant_id, client_id, user_id, numero, date_commande, statut, montant_total, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: factures_client; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.factures_client (id, tenant_id, commande_id, client_id, user_id, numero, date_facture, montant_ht, tva, montant_ttc, montant_regle, statut, type_vente, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: factures_fournisseur; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.factures_fournisseur (id, tenant_id, bon_commande_id, fournisseur_id, user_id, numero, date_facture, date_echeance, montant_ht, tva, montant_ttc, montant_regle, statut, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.failed_jobs (id, uuid, connection, queue, payload, exception, failed_at) FROM stdin;
\.


--
-- Data for Name: familles_produits; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.familles_produits (id, tenant_id, nom, description, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: fournisseurs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.fournisseurs (id, tenant_id, nom, telephone, email, adresse, numero_contribuable, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.job_batches (id, name, total_jobs, pending_jobs, failed_jobs, failed_job_ids, options, cancelled_at, created_at, finished_at) FROM stdin;
\.


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.jobs (id, queue, payload, attempts, reserved_at, available_at, created_at) FROM stdin;
\.


--
-- Data for Name: lignes_bon_entree; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.lignes_bon_entree (id, bon_entree_id, produit_id, quantite, valeur_unitaire, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: lignes_bon_sortie; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.lignes_bon_sortie (id, bon_sortie_id, produit_id, quantite, valeur_unitaire, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: lignes_commande_client; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.lignes_commande_client (id, commande_id, produit_id, quantite, prix_unitaire, remise, montant, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: lignes_commande_fournisseur; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.lignes_commande_fournisseur (id, bon_commande_id, produit_id, quantite_commandee, quantite_recue, prix_unitaire, montant, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.migrations (id, migration, batch) FROM stdin;
1	0001_01_01_000000_create_users_table	1
2	0001_01_01_000001_create_cache_table	1
3	0001_01_01_000002_create_jobs_table	1
4	2026_05_28_104522_create_permission_tables	2
5	2026_05_28_105254_create_tenants_table	3
6	2026_05_28_105303_create_familles_produits_table	3
7	2026_05_28_105313_create_produits_table	3
8	2026_05_28_105352_create_fournisseurs_table	3
9	2026_05_28_105400_create_categories_clients_table	3
10	2026_05_28_105409_create_clients_table	3
11	2026_05_28_105417_create_banques_table	3
12	2026_05_28_105427_create_bons_commande_fournisseur_table	3
13	2026_05_28_105435_create_lignes_commande_fournisseur_table	3
14	2026_05_28_105445_create_factures_fournisseur_table	3
15	2026_05_28_105452_create_bons_entree_table	3
16	2026_05_28_105501_create_lignes_bon_entree_table	3
17	2026_05_28_105509_create_commandes_client_table	3
18	2026_05_28_105517_create_lignes_commande_client_table	3
19	2026_05_28_105526_create_factures_client_table	3
20	2026_05_28_105533_create_bons_sortie_table	3
21	2026_05_28_105542_create_lignes_bon_sortie_table	3
22	2026_05_28_105551_create_versements_banque_table	3
\.


--
-- Data for Name: model_has_permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.model_has_permissions (permission_id, model_type, model_id) FROM stdin;
\.


--
-- Data for Name: model_has_roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.model_has_roles (role_id, model_type, model_id) FROM stdin;
\.


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.password_reset_tokens (email, token, created_at) FROM stdin;
\.


--
-- Data for Name: permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.permissions (id, name, guard_name, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: produits; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.produits (id, tenant_id, famille_id, produit_parent_id, code, nom, unite, prix_achat, prix_vente, stock_actuel, stock_minimum, date_expiration, type, facteur_fraction, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: role_has_permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.role_has_permissions (permission_id, role_id) FROM stdin;
\.


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.roles (id, name, guard_name, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.sessions (id, user_id, ip_address, user_agent, payload, last_activity) FROM stdin;
wEFi5eqYnDshw3yOXxFzyA9mPCpkcxJOs7imEKTE	\N	127.0.0.1	Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/148.0.0.0 Safari/537.36 Edg/148.0.0.0	YTozOntzOjY6Il90b2tlbiI7czo0MDoiWDZZbkVvdFRud1hpZ3pSQnpsTE5vTDF0cm9mUEVyZnhEYnJWWUM0eSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7Tjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==	1779965515
\.


--
-- Data for Name: tenants; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.tenants (id, nom_entreprise, slug, email, telephone, adresse, statut, date_expiration, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.users (id, name, email, email_verified_at, password, remember_token, created_at, updated_at) FROM stdin;
\.


--
-- Data for Name: versements_banque; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.versements_banque (id, tenant_id, banque_id, user_id, montant, date_versement, reference, notes, created_at, updated_at) FROM stdin;
\.


--
-- Name: banques_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.banques_id_seq', 1, false);


--
-- Name: bons_commande_fournisseur_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.bons_commande_fournisseur_id_seq', 1, false);


--
-- Name: bons_entree_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.bons_entree_id_seq', 1, false);


--
-- Name: bons_sortie_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.bons_sortie_id_seq', 1, false);


--
-- Name: categories_clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.categories_clients_id_seq', 1, false);


--
-- Name: clients_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.clients_id_seq', 1, false);


--
-- Name: commandes_client_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.commandes_client_id_seq', 1, false);


--
-- Name: factures_client_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.factures_client_id_seq', 1, false);


--
-- Name: factures_fournisseur_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.factures_fournisseur_id_seq', 1, false);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- Name: familles_produits_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.familles_produits_id_seq', 1, false);


--
-- Name: fournisseurs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.fournisseurs_id_seq', 1, false);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- Name: lignes_bon_entree_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.lignes_bon_entree_id_seq', 1, false);


--
-- Name: lignes_bon_sortie_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.lignes_bon_sortie_id_seq', 1, false);


--
-- Name: lignes_commande_client_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.lignes_commande_client_id_seq', 1, false);


--
-- Name: lignes_commande_fournisseur_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.lignes_commande_fournisseur_id_seq', 1, false);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.migrations_id_seq', 22, true);


--
-- Name: permissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.permissions_id_seq', 1, false);


--
-- Name: produits_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.produits_id_seq', 1, false);


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.roles_id_seq', 1, false);


--
-- Name: tenants_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.tenants_id_seq', 1, false);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.users_id_seq', 1, false);


--
-- Name: versements_banque_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.versements_banque_id_seq', 1, false);


--
-- Name: banques banques_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.banques
    ADD CONSTRAINT banques_pkey PRIMARY KEY (id);


--
-- Name: bons_commande_fournisseur bons_commande_fournisseur_numero_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bons_commande_fournisseur
    ADD CONSTRAINT bons_commande_fournisseur_numero_unique UNIQUE (numero);


--
-- Name: bons_commande_fournisseur bons_commande_fournisseur_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bons_commande_fournisseur
    ADD CONSTRAINT bons_commande_fournisseur_pkey PRIMARY KEY (id);


--
-- Name: bons_entree bons_entree_numero_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bons_entree
    ADD CONSTRAINT bons_entree_numero_unique UNIQUE (numero);


--
-- Name: bons_entree bons_entree_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bons_entree
    ADD CONSTRAINT bons_entree_pkey PRIMARY KEY (id);


--
-- Name: bons_sortie bons_sortie_numero_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bons_sortie
    ADD CONSTRAINT bons_sortie_numero_unique UNIQUE (numero);


--
-- Name: bons_sortie bons_sortie_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bons_sortie
    ADD CONSTRAINT bons_sortie_pkey PRIMARY KEY (id);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: categories_clients categories_clients_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories_clients
    ADD CONSTRAINT categories_clients_pkey PRIMARY KEY (id);


--
-- Name: clients clients_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_pkey PRIMARY KEY (id);


--
-- Name: commandes_client commandes_client_numero_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commandes_client
    ADD CONSTRAINT commandes_client_numero_unique UNIQUE (numero);


--
-- Name: commandes_client commandes_client_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commandes_client
    ADD CONSTRAINT commandes_client_pkey PRIMARY KEY (id);


--
-- Name: factures_client factures_client_numero_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.factures_client
    ADD CONSTRAINT factures_client_numero_unique UNIQUE (numero);


--
-- Name: factures_client factures_client_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.factures_client
    ADD CONSTRAINT factures_client_pkey PRIMARY KEY (id);


--
-- Name: factures_fournisseur factures_fournisseur_numero_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.factures_fournisseur
    ADD CONSTRAINT factures_fournisseur_numero_unique UNIQUE (numero);


--
-- Name: factures_fournisseur factures_fournisseur_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.factures_fournisseur
    ADD CONSTRAINT factures_fournisseur_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: familles_produits familles_produits_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.familles_produits
    ADD CONSTRAINT familles_produits_pkey PRIMARY KEY (id);


--
-- Name: fournisseurs fournisseurs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fournisseurs
    ADD CONSTRAINT fournisseurs_pkey PRIMARY KEY (id);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: lignes_bon_entree lignes_bon_entree_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lignes_bon_entree
    ADD CONSTRAINT lignes_bon_entree_pkey PRIMARY KEY (id);


--
-- Name: lignes_bon_sortie lignes_bon_sortie_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lignes_bon_sortie
    ADD CONSTRAINT lignes_bon_sortie_pkey PRIMARY KEY (id);


--
-- Name: lignes_commande_client lignes_commande_client_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lignes_commande_client
    ADD CONSTRAINT lignes_commande_client_pkey PRIMARY KEY (id);


--
-- Name: lignes_commande_fournisseur lignes_commande_fournisseur_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lignes_commande_fournisseur
    ADD CONSTRAINT lignes_commande_fournisseur_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: model_has_permissions model_has_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_pkey PRIMARY KEY (permission_id, model_id, model_type);


--
-- Name: model_has_roles model_has_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_pkey PRIMARY KEY (role_id, model_id, model_type);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: permissions permissions_name_guard_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_name_guard_name_unique UNIQUE (name, guard_name);


--
-- Name: permissions permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id);


--
-- Name: produits produits_code_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produits
    ADD CONSTRAINT produits_code_unique UNIQUE (code);


--
-- Name: produits produits_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produits
    ADD CONSTRAINT produits_pkey PRIMARY KEY (id);


--
-- Name: role_has_permissions role_has_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_pkey PRIMARY KEY (permission_id, role_id);


--
-- Name: roles roles_name_guard_name_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_name_guard_name_unique UNIQUE (name, guard_name);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: tenants tenants_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tenants
    ADD CONSTRAINT tenants_email_unique UNIQUE (email);


--
-- Name: tenants tenants_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tenants
    ADD CONSTRAINT tenants_pkey PRIMARY KEY (id);


--
-- Name: tenants tenants_slug_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.tenants
    ADD CONSTRAINT tenants_slug_unique UNIQUE (slug);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: versements_banque versements_banque_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.versements_banque
    ADD CONSTRAINT versements_banque_pkey PRIMARY KEY (id);


--
-- Name: cache_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


--
-- Name: cache_locks_expiration_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: model_has_permissions_model_id_model_type_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX model_has_permissions_model_id_model_type_index ON public.model_has_permissions USING btree (model_id, model_type);


--
-- Name: model_has_roles_model_id_model_type_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX model_has_roles_model_id_model_type_index ON public.model_has_roles USING btree (model_id, model_type);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: banques banques_tenant_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.banques
    ADD CONSTRAINT banques_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES public.tenants(id) ON DELETE CASCADE;


--
-- Name: bons_commande_fournisseur bons_commande_fournisseur_fournisseur_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bons_commande_fournisseur
    ADD CONSTRAINT bons_commande_fournisseur_fournisseur_id_foreign FOREIGN KEY (fournisseur_id) REFERENCES public.fournisseurs(id) ON DELETE CASCADE;


--
-- Name: bons_commande_fournisseur bons_commande_fournisseur_tenant_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bons_commande_fournisseur
    ADD CONSTRAINT bons_commande_fournisseur_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES public.tenants(id) ON DELETE CASCADE;


--
-- Name: bons_commande_fournisseur bons_commande_fournisseur_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bons_commande_fournisseur
    ADD CONSTRAINT bons_commande_fournisseur_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: bons_entree bons_entree_tenant_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bons_entree
    ADD CONSTRAINT bons_entree_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES public.tenants(id) ON DELETE CASCADE;


--
-- Name: bons_entree bons_entree_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bons_entree
    ADD CONSTRAINT bons_entree_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: bons_sortie bons_sortie_tenant_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bons_sortie
    ADD CONSTRAINT bons_sortie_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES public.tenants(id) ON DELETE CASCADE;


--
-- Name: bons_sortie bons_sortie_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.bons_sortie
    ADD CONSTRAINT bons_sortie_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: categories_clients categories_clients_tenant_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.categories_clients
    ADD CONSTRAINT categories_clients_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES public.tenants(id) ON DELETE CASCADE;


--
-- Name: clients clients_categorie_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_categorie_id_foreign FOREIGN KEY (categorie_id) REFERENCES public.categories_clients(id) ON DELETE CASCADE;


--
-- Name: clients clients_tenant_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.clients
    ADD CONSTRAINT clients_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES public.tenants(id) ON DELETE CASCADE;


--
-- Name: commandes_client commandes_client_client_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commandes_client
    ADD CONSTRAINT commandes_client_client_id_foreign FOREIGN KEY (client_id) REFERENCES public.clients(id) ON DELETE CASCADE;


--
-- Name: commandes_client commandes_client_tenant_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commandes_client
    ADD CONSTRAINT commandes_client_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES public.tenants(id) ON DELETE CASCADE;


--
-- Name: commandes_client commandes_client_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.commandes_client
    ADD CONSTRAINT commandes_client_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: factures_client factures_client_client_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.factures_client
    ADD CONSTRAINT factures_client_client_id_foreign FOREIGN KEY (client_id) REFERENCES public.clients(id) ON DELETE CASCADE;


--
-- Name: factures_client factures_client_commande_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.factures_client
    ADD CONSTRAINT factures_client_commande_id_foreign FOREIGN KEY (commande_id) REFERENCES public.commandes_client(id) ON DELETE CASCADE;


--
-- Name: factures_client factures_client_tenant_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.factures_client
    ADD CONSTRAINT factures_client_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES public.tenants(id) ON DELETE CASCADE;


--
-- Name: factures_client factures_client_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.factures_client
    ADD CONSTRAINT factures_client_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: factures_fournisseur factures_fournisseur_bon_commande_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.factures_fournisseur
    ADD CONSTRAINT factures_fournisseur_bon_commande_id_foreign FOREIGN KEY (bon_commande_id) REFERENCES public.bons_commande_fournisseur(id) ON DELETE CASCADE;


--
-- Name: factures_fournisseur factures_fournisseur_fournisseur_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.factures_fournisseur
    ADD CONSTRAINT factures_fournisseur_fournisseur_id_foreign FOREIGN KEY (fournisseur_id) REFERENCES public.fournisseurs(id) ON DELETE CASCADE;


--
-- Name: factures_fournisseur factures_fournisseur_tenant_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.factures_fournisseur
    ADD CONSTRAINT factures_fournisseur_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES public.tenants(id) ON DELETE CASCADE;


--
-- Name: factures_fournisseur factures_fournisseur_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.factures_fournisseur
    ADD CONSTRAINT factures_fournisseur_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- Name: familles_produits familles_produits_tenant_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.familles_produits
    ADD CONSTRAINT familles_produits_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES public.tenants(id) ON DELETE CASCADE;


--
-- Name: fournisseurs fournisseurs_tenant_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.fournisseurs
    ADD CONSTRAINT fournisseurs_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES public.tenants(id) ON DELETE CASCADE;


--
-- Name: lignes_bon_entree lignes_bon_entree_bon_entree_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lignes_bon_entree
    ADD CONSTRAINT lignes_bon_entree_bon_entree_id_foreign FOREIGN KEY (bon_entree_id) REFERENCES public.bons_entree(id) ON DELETE CASCADE;


--
-- Name: lignes_bon_entree lignes_bon_entree_produit_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lignes_bon_entree
    ADD CONSTRAINT lignes_bon_entree_produit_id_foreign FOREIGN KEY (produit_id) REFERENCES public.produits(id) ON DELETE CASCADE;


--
-- Name: lignes_bon_sortie lignes_bon_sortie_bon_sortie_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lignes_bon_sortie
    ADD CONSTRAINT lignes_bon_sortie_bon_sortie_id_foreign FOREIGN KEY (bon_sortie_id) REFERENCES public.bons_sortie(id) ON DELETE CASCADE;


--
-- Name: lignes_bon_sortie lignes_bon_sortie_produit_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lignes_bon_sortie
    ADD CONSTRAINT lignes_bon_sortie_produit_id_foreign FOREIGN KEY (produit_id) REFERENCES public.produits(id) ON DELETE CASCADE;


--
-- Name: lignes_commande_client lignes_commande_client_commande_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lignes_commande_client
    ADD CONSTRAINT lignes_commande_client_commande_id_foreign FOREIGN KEY (commande_id) REFERENCES public.commandes_client(id) ON DELETE CASCADE;


--
-- Name: lignes_commande_client lignes_commande_client_produit_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lignes_commande_client
    ADD CONSTRAINT lignes_commande_client_produit_id_foreign FOREIGN KEY (produit_id) REFERENCES public.produits(id) ON DELETE CASCADE;


--
-- Name: lignes_commande_fournisseur lignes_commande_fournisseur_bon_commande_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lignes_commande_fournisseur
    ADD CONSTRAINT lignes_commande_fournisseur_bon_commande_id_foreign FOREIGN KEY (bon_commande_id) REFERENCES public.bons_commande_fournisseur(id) ON DELETE CASCADE;


--
-- Name: lignes_commande_fournisseur lignes_commande_fournisseur_produit_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.lignes_commande_fournisseur
    ADD CONSTRAINT lignes_commande_fournisseur_produit_id_foreign FOREIGN KEY (produit_id) REFERENCES public.produits(id) ON DELETE CASCADE;


--
-- Name: model_has_permissions model_has_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- Name: model_has_roles model_has_roles_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: produits produits_famille_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produits
    ADD CONSTRAINT produits_famille_id_foreign FOREIGN KEY (famille_id) REFERENCES public.familles_produits(id) ON DELETE CASCADE;


--
-- Name: produits produits_produit_parent_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produits
    ADD CONSTRAINT produits_produit_parent_id_foreign FOREIGN KEY (produit_parent_id) REFERENCES public.produits(id) ON DELETE CASCADE;


--
-- Name: produits produits_tenant_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.produits
    ADD CONSTRAINT produits_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES public.tenants(id) ON DELETE CASCADE;


--
-- Name: role_has_permissions role_has_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- Name: role_has_permissions role_has_permissions_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: versements_banque versements_banque_banque_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.versements_banque
    ADD CONSTRAINT versements_banque_banque_id_foreign FOREIGN KEY (banque_id) REFERENCES public.banques(id) ON DELETE CASCADE;


--
-- Name: versements_banque versements_banque_tenant_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.versements_banque
    ADD CONSTRAINT versements_banque_tenant_id_foreign FOREIGN KEY (tenant_id) REFERENCES public.tenants(id) ON DELETE CASCADE;


--
-- Name: versements_banque versements_banque_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.versements_banque
    ADD CONSTRAINT versements_banque_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

\unrestrict Zk85swngZ8MITWN5f4wHAxqzhvbtQbNKf5dvvy5AJZRq0Xlmia7tMctFFK6KEf7

