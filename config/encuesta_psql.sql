--
-- PostgreSQL database dump
--

-- Dumped from database version 15.5
-- Dumped by pg_dump version 15.5

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

COMMENT ON SCHEMA public IS '';
SET default_tablespace = '';
SET default_table_access_method = heap;

----------------------------------------------------------------------
---------------------- Tablas de administración ----------------------
----------------------------------------------------------------------

CREATE TABLE public.admin_menu (
    id bigint NOT NULL,
    parent_id bigint DEFAULT '0'::bigint NOT NULL,
    "order" bigint DEFAULT '0'::bigint NOT NULL,
    title character varying(50) NOT NULL,
    icon character varying(50) NOT NULL,
    uri character varying(255) DEFAULT NULL::character varying,
    permission character varying(255) DEFAULT NULL::character varying,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);
ALTER TABLE public.admin_menu OWNER TO fgonzalez;
CREATE SEQUENCE public.admin_menu_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.admin_menu_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.admin_menu_id_seq OWNED BY public.admin_menu.id;

----------------------------------------------------------------------
CREATE TABLE public.admin_operation_log (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    path character varying(255) NOT NULL,
    method character varying(10) NOT NULL,
    ip character varying(255) NOT NULL,
    input text NOT NULL,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);
ALTER TABLE public.admin_operation_log OWNER TO fgonzalez;
CREATE SEQUENCE public.admin_operation_log_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.admin_operation_log_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.admin_operation_log_id_seq OWNED BY public.admin_operation_log.id;
----------------------------------------------------------------------

CREATE TABLE public.admin_permissions (
    id bigint NOT NULL,
    name character varying(50) NOT NULL,
    slug character varying(50) NOT NULL,
    http_method character varying(255) DEFAULT NULL::character varying,
    http_path text,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);
ALTER TABLE public.admin_permissions OWNER TO fgonzalez;
CREATE SEQUENCE public.admin_permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.admin_permissions_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.admin_permissions_id_seq OWNED BY public.admin_permissions.id;

----------------------------------------------------------------------
CREATE TABLE public.admin_role_menu (
    role_id bigint NOT NULL,
    menu_id bigint NOT NULL,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);
ALTER TABLE public.admin_role_menu OWNER TO fgonzalez;

----------------------------------------------------------------------
CREATE TABLE public.admin_role_permissions (
    role_id bigint NOT NULL,
    permission_id bigint NOT NULL,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);
ALTER TABLE public.admin_role_permissions OWNER TO fgonzalez;

----------------------------------------------------------------------
CREATE TABLE public.admin_role_users (
    role_id bigint NOT NULL,
    user_id bigint NOT NULL,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);
ALTER TABLE public.admin_role_users OWNER TO fgonzalez;

----------------------------------------------------------------------
CREATE TABLE public.admin_roles (
    id bigint NOT NULL,
    name character varying(50) NOT NULL,
    slug character varying(50) NOT NULL,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);
ALTER TABLE public.admin_roles OWNER TO fgonzalez;
CREATE SEQUENCE public.admin_roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.admin_roles_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.admin_roles_id_seq OWNED BY public.admin_roles.id;

----------------------------------------------------------------------
CREATE TABLE public.admin_user_permissions (
    user_id bigint NOT NULL,
    permission_id bigint NOT NULL,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);
ALTER TABLE public.admin_user_permissions OWNER TO fgonzalez;

----------------------------------------------------------------------
CREATE TABLE public.admin_users (
    id bigint NOT NULL,
    username character varying(190) NOT NULL,
    password character varying(60) NOT NULL,
    name character varying(255) NOT NULL,
    avatar character varying(255) DEFAULT NULL::character varying,
    remember_token character varying(100) DEFAULT NULL::character varying,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);
ALTER TABLE public.admin_users OWNER TO fgonzalez;
CREATE SEQUENCE public.admin_users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.admin_users_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.admin_users_id_seq OWNED BY public.admin_users.id;
----------------------------------------------------------------------
CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);
ALTER TABLE public.failed_jobs OWNER TO fgonzalez;
CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.failed_jobs_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;

----------------------------------------------------------------------
CREATE TABLE public.migrations (
    id bigint NOT NULL,
    migration character varying(255) NOT NULL,
    batch bigint NOT NULL
);
ALTER TABLE public.migrations OWNER TO fgonzalez;
CREATE SEQUENCE public.migrations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.migrations_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;
----------------------------------------------------------------------
--------------------------Tablas de encuesta--------------------------
----------------------------------------------------------------------

CREATE TABLE public.bloqueos (
    id bigint NOT NULL,
    clave_reactivo character varying(45) DEFAULT NULL::character varying,
    valor bigint,
    bloqueado character varying(45) DEFAULT NULL::character varying
);
ALTER TABLE public.bloqueos OWNER TO fgonzalez;
CREATE SEQUENCE public.bloqueos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.bloqueos_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.bloqueos_id_seq OWNED BY public.bloqueos.id;

----------------------------------------------------------------------
CREATE TABLE public.carreras (
    id bigint NOT NULL,
    clave_carrera character varying(50),
    clave_plantel character varying(70),
    carrera character varying(100) DEFAULT NULL::character varying,
    plantel character varying(100) DEFAULT NULL::character varying,
    area bigint
);
ALTER TABLE public.carreras OWNER TO fgonzalez;
CREATE SEQUENCE public.carreras_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.carreras_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.carreras_id_seq OWNED BY public.carreras.id;

----------------------------------------------------------------------
CREATE TABLE public.codigos (
    code character varying(45) NOT NULL,
    description character varying(100) DEFAULT NULL::character varying,
    color character varying(45) DEFAULT NULL::character varying,
    color_rgb character varying(45) DEFAULT NULL::character varying,
    "order" character varying(7) DEFAULT NULL::character varying
);
ALTER TABLE public.codigos OWNER TO fgonzalez;

----------------------------------------------------------------------
CREATE TABLE public.comentario (
    registro bigint NOT NULL,
    cuenta character varying(15) DEFAULT ''::character varying,
    comentario text,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);
CREATE SEQUENCE comentario_registro_seq;
ALTER TABLE public.comentario OWNER TO fgonzalez;
ALTER TABLE ONLY public.comentario ALTER COLUMN registro SET DEFAULT nextval('comentario_registro_seq'::regclass);


----------------------------------------------------------------------
CREATE TABLE public.empresas (
    id bigint NOT NULL,
    usuario character varying(20),
    nombre character varying(150),
    giro character varying(75),
    clave_giro character varying(20),
    giro_especifico character varying(150),
    nota character varying(250),
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);
CREATE SEQUENCE empresas_id_seq;
ALTER TABLE public.empresas OWNER TO fgonzalez;
ALTER TABLE ONLY public.empresas ALTER COLUMN id SET DEFAULT nextval('empresas_id_seq'::regclass);

----------------------------------------------------------------------
CREATE TABLE public.correos (
    id bigint NOT NULL,
    correo character varying(255) DEFAULT NULL::character varying,
    cuenta character varying(15),
    status character varying(45) DEFAULT NULL::character varying,
    created_at date,
    updated_at date,
    enviado bigint DEFAULT '0'::bigint
);
ALTER TABLE public.correos OWNER TO fgonzalez;
CREATE SEQUENCE public.correos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.correos_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.correos_id_seq OWNED BY public.correos.id;


----------------------------------------------------------------------
CREATE TABLE public.respuestas2 (
    registro bigint NOT NULL,
    aplica character varying(20) DEFAULT NULL::character varying,
    aplica2 character varying(30) DEFAULT NULL::character varying,
    fec_capt timestamp with time zone,
    fec_capt2 timestamp with time zone,
    cuenta character varying(15) DEFAULT NULL::character varying,
    nombre character varying(50) DEFAULT NULL::character varying,
    paterno character varying(50) DEFAULT NULL::character varying,
    materno character varying(50) DEFAULT NULL::character varying,
    telcasa character varying(14) DEFAULT NULL::character varying,
    telcel character varying(25) DEFAULT NULL::character varying,
    teltra character varying(14) DEFAULT NULL::character varying,
    exttra character varying(6) DEFAULT NULL::character varying,
    dianac smallint,
    mesnac smallint,
    yernac smallint,
    nar1 smallint,
    nar1_a character varying(50) DEFAULT NULL::character varying,
    nar2a smallint,
    nar3a smallint,
    nar4a smallint,
    nar5a smallint,
    nar7 smallint,
    nar8 smallint,
    nar9 smallint,
    nar10 character(2) DEFAULT NULL::bpchar,
    nar11 smallint,
    nar11a character varying(50) DEFAULT NULL::character varying,
    nar12 smallint,
    nar12a character varying(50) DEFAULT NULL::character varying,
    nar13 smallint,
    nar13a character varying(50) DEFAULT NULL::character varying,
    nar14 smallint,
    nar14otra character varying(100) DEFAULT NULL::character varying,
    nar15 smallint,
    nar15otra character varying(100) DEFAULT NULL::character varying,
    nar16 smallint,
    nar16otra character varying(100) DEFAULT NULL::character varying,
    nbr1 smallint,
    nbr2 character varying(50) DEFAULT NULL::character varying,
    nbr3 character varying(70) DEFAULT NULL::character varying,
    nbr3_a smallint,
    nbr6 character varying(4) DEFAULT NULL::character varying,
    nbr7 character varying(4) DEFAULT NULL::character varying,
    nbr8 smallint,
    ncr1 smallint,
    ncr2 character varying(230) DEFAULT NULL::character varying,
    ncr2a smallint,
    ncr3 smallint,
    ncr4 smallint,
    ncr4otra character varying(100) DEFAULT NULL::character varying,
    ncr5 smallint,
    ncr6 smallint,
    ncr6_a character varying(100) DEFAULT NULL::character varying,
    ncr7_a character varying(100) DEFAULT NULL::character varying,
    ncr7b smallint,
    ncr8 smallint,
    ncr9 smallint,
    ncr10 smallint,
    ncr11 smallint,
    ncr12_a character varying(120) DEFAULT NULL::character varying,
    ncr15 smallint,
    ncr16 smallint,
    ncr17 smallint,
    ncr18 smallint,
    ncr19 smallint,
    ncr20 smallint,
    ncr21 smallint,
    ncr21_a character varying(11) DEFAULT NULL::character varying,
    ncr21b smallint,
    ncr22 smallint,
    ncr23 smallint,
    ncr24 smallint,
    ncr24porque smallint,
    ncr24_a character varying(100) DEFAULT NULL::character varying,
    ndr1 smallint,
    ndr2 smallint,
    ndr2_a character varying(100) DEFAULT NULL::character varying,
    ndr3 smallint,
    ndr4 smallint,
    ndr5 smallint,
    ndr6 smallint,
    ndr9 smallint,
    ndr7 smallint,
    ndr8 smallint,
    ndr10 smallint,
    ndr11 smallint,
    ndr12 smallint,
    ndr12a smallint,
    ndr12b smallint,
    ndr12c smallint,
    ndr13a character varying(100) DEFAULT NULL::character varying,
    ndr14 smallint,
    ndr15 smallint,
    ndr16 smallint,
    ndr17 smallint,
    ndr18 smallint,
    ndr19 smallint,
    ner1 smallint,
    ner1a smallint,
    ner2 smallint,
    ner3 smallint,
    ner4 smallint,
    ner5 smallint,
    ner6 smallint,
    ner7 smallint,
    ner7_a character varying(100) DEFAULT NULL::character varying,
    ner7int smallint,
    ner8 smallint,
    ner9 smallint,
    ner10 smallint,
    ner10a character varying(100) DEFAULT NULL::character varying,
    ner11 smallint,
    ner12 smallint,
    ner12a smallint,
    ner12b character varying(100) DEFAULT NULL::character varying,
    ner13 smallint,
    ner14 smallint,
    ner15 smallint,
    ner16 smallint,
    ner17 smallint,
    ner18 smallint,
    ner19 smallint,
    ner19a character varying(80) DEFAULT NULL::character varying,
    ner20 smallint,
    ner20txt character varying(100) DEFAULT NULL::character varying,
    ner20a smallint,
    nfr0 smallint,
    nfr1 smallint,
    nfr1a character varying(50) DEFAULT NULL::character varying,
    nfr2 smallint,
    nfr3 smallint,
    nfr7 smallint,
    nfr4 smallint,
    nfr4_a character varying(50) DEFAULT NULL::character varying,
    nfr5 smallint,
    nfr5_a character varying(100) DEFAULT NULL::character varying,
    nfr6 smallint,
    nfr6_a character varying(100) DEFAULT NULL::character varying,
    nfr8 smallint,
    nfr9 smallint,
    nfr10 smallint,
    nfr11 smallint,
    nfr11a character varying(100) DEFAULT NULL::character varying,
    nfr12 smallint,
    nfr13 smallint,
    nfr22 smallint,
    nfr23 smallint,
    nfr24 character varying(100) DEFAULT NULL::character varying,
    nfr25 smallint,
    nfr26 smallint,
    nfr27 smallint,
    nfr28 smallint,
    nfr29 smallint,
    nfr29a character varying(100) DEFAULT NULL::character varying,
    nfr30 smallint,
    nfr31 smallint,
    nfr32 smallint,
    nfr33 smallint,
    ngr1 smallint,
    ngr2 smallint,
    ngr3 smallint,
    ngr3b smallint,
    ngr3c smallint,
    ngr3d smallint,
    ngr3e smallint,
    ngr4 smallint,
    ngr5 smallint,
    ngr6 smallint,
    ngr6a smallint,
    ngr6b smallint,
    ngr6c smallint,
    ngr6d smallint,
    ngr6e smallint,
    ngr6f smallint,
    ngr6g smallint,
    ngr6_t character varying(50) DEFAULT NULL::character varying,
    ngr7a smallint,
    ngr7b smallint,
    ngr7c smallint,
    ngr7d smallint,
    ngr7e smallint,
    ngr7f smallint,
    ngr7g smallint,
    ngr8 smallint,
    ngr9a smallint,
    ngr9b smallint,
    ngr9c smallint,
    ngr9d smallint,
    ngr9e smallint,
    ngr11a smallint,
    ngr11 smallint,
    ngr11_a character varying(50) DEFAULT NULL::character varying,
    ngr13 smallint,
    ngr13b smallint,
    ngr13c smallint,
    ngr13d smallint,
    ngr13e smallint,
    ngr14 smallint,
    ngr15 smallint,
    ngr16 smallint,
    ngr17 smallint,
    ngr18 smallint,
    ngr19 smallint,
    ngr20 smallint,
    ngr21 smallint,
    ngr22 smallint,
    ngr23 smallint,
    ngr24 smallint,
    ngr25 smallint,
    ngr26 smallint,
    ngr27 smallint,
    ngr28 smallint,
    ngr29 smallint,
    ngr30 smallint,
    ngr31 smallint,
    ngr32 smallint,
    ngr33 smallint,
    ngr34 smallint,
    ngr35 smallint,
    ngr36 smallint,
    ngr37 smallint,
    ngr37m smallint,
    ngr37_a smallint,
    ngr38 smallint,
    ngr39 smallint,
    ngr40 smallint,
    ngr40a smallint,
    ngr40_a character varying(50) DEFAULT NULL::character varying,
    ngr40_b smallint,
    ngr41 smallint,
    ngr42 smallint,
    ngr43 smallint,
    ngr44 smallint,
    ngr45 smallint,
    ngr45_a smallint,
    ngr45otra character varying(100) DEFAULT NULL::character varying,
    conoce smallint,
    cue_cre smallint,
    utiliza smallint,
    nrx smallint,
    nrxx character varying(50) DEFAULT NULL::character varying,
    ngr11b integer,
    ngr11c integer,
    ngr11d integer,
    ngr11e integer,
    ngr11f integer,
    gen_dgae smallint,
    completed bigint DEFAULT '0'::bigint,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);
ALTER TABLE public.respuestas2 OWNER TO postgres;

----------------------------------------------------------------------
CREATE TABLE public.egresados (
    id bigint NOT NULL,
    cuenta character varying(15),
    nombre character varying(45) DEFAULT NULL::character varying,
    paterno character varying(45) DEFAULT NULL::character varying,
    materno character varying(45) DEFAULT NULL::character varying,
    carrera character varying(50),
    plantel character varying(50),
    extras bigint,
    promedio double precision,
    correo character varying(80) DEFAULT NULL::character varying,
    telefono character varying(45) DEFAULT NULL::character varying,
    telefono2 character varying(45) DEFAULT NULL::character varying,
    anio_egreso bigint,
    correo2 character varying(80) DEFAULT NULL::character varying,
    bach bigint,
    correo_unam character varying(110) DEFAULT NULL::character varying,
    sistema character varying(45) DEFAULT NULL::character varying,
    muestra bigint,
    status character varying(45),
    llamadas bigint DEFAULT '0'::bigint,
    updated_at timestamp with time zone,
    sexo character varying(45) DEFAULT NULL::character varying,
    fec_nac date,
    actualized timestamp with time zone,
    fuente character varying(45) DEFAULT 'dgae'::character varying,
    created_at timestamp with time zone
);
ALTER TABLE public.egresados OWNER TO fgonzalez;
CREATE SEQUENCE public.egresados_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.egresados_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.egresados_id_seq OWNED BY public.egresados.id;

----------------------------------------------------------------------
CREATE TABLE public.encuestador_muestra (
    id bigint NOT NULL,
    user_id bigint,
    estudio_id bigint,
    carrera bigint,
    plantel bigint
);
ALTER TABLE public.encuestador_muestra OWNER TO fgonzalez;

----------------------------------------------------------------------
CREATE TABLE public.estudios (
    id bigint NOT NULL,
    gen bigint,
    actualizacion bigint DEFAULT '0'::bigint,
    start_date timestamp with time zone,
    end_date character varying(45) DEFAULT NULL::character varying,
    estudiocol character varying(45) DEFAULT NULL::character varying
);
ALTER TABLE public.estudios OWNER TO fgonzalez;
CREATE SEQUENCE public.estudios_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.estudios_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.estudios_id_seq OWNED BY public.estudios.id;

----------------------------------------------------------------------
CREATE TABLE public.muestras (
    id bigint NOT NULL,
    estudio_id bigint,
    carrera_id character varying(50),
    plantel_id character varying(50),
    enc_id bigint,
    requeridas_10 bigint,
    requeridas_5 bigint,
    dispersion double precision,
    poblacion bigint
);
ALTER TABLE public.muestras OWNER TO fgonzalez;
CREATE SEQUENCE public.muestras_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.muestras_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.muestras_id_seq OWNED BY public.muestras.id;

----------------------------------------------------------------------
CREATE TABLE public.multiple_option_answers (
    id bigint NOT NULL,
    encuesta_id bigint,
    reactivo character varying(30) DEFAULT NULL::character varying,
    clave_opcion bigint,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);
ALTER TABLE public.multiple_option_answers OWNER TO fgonzalez;
CREATE SEQUENCE public.multiple_option_answers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.multiple_option_answers_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.multiple_option_answers_id_seq OWNED BY public.multiple_option_answers.id;

----------------------------------------------------------------------
CREATE TABLE public.options (
    id bigint NOT NULL,
    reactivo character varying(50) DEFAULT NULL::character varying,
    clave bigint,
    descripcion character varying(225) DEFAULT NULL::character varying,
    updated_at date,
    "order" character varying(5) DEFAULT NULL::character varying
);
ALTER TABLE public.options OWNER TO fgonzalez;
CREATE SEQUENCE public.options_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.options_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.options_id_seq OWNED BY public.options.id;

----------------------------------------------------------------------
CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp with time zone
);
ALTER TABLE public.password_reset_tokens OWNER TO fgonzalez;
CREATE TABLE public.password_resets (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp with time zone
);
ALTER TABLE public.password_resets OWNER TO fgonzalez;

----------------------------------------------------------------------
CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id numeric NOT NULL,
    name character varying(255) NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp with time zone,
    expires_at timestamp with time zone,
    created_at timestamp with time zone,
    updated_at timestamp with time zone
);
ALTER TABLE public.personal_access_tokens OWNER TO fgonzalez;
CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.personal_access_tokens_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


----------------------------------------------------------------------
CREATE TABLE public.reactivos (
    id bigint NOT NULL,
    clave character varying(45) DEFAULT NULL::character varying,
    description character varying(255) DEFAULT NULL::character varying,
    type character varying(45) DEFAULT NULL::character varying,
    rules text,
    section character varying(45) DEFAULT NULL::character varying,
    "order" double precision,
    archtype character varying(45) DEFAULT NULL::character varying,
    child bigint DEFAULT '0'::bigint,
    aux bigint DEFAULT '0'::bigint,
    extra_label character varying(255) DEFAULT NULL::character varying,
    created_at date,
    updated_at date
);
ALTER TABLE public.reactivos OWNER TO fgonzalez;
CREATE SEQUENCE public.reactivos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.reactivos_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.reactivos_id_seq OWNED BY public.reactivos.id;

----------------------------------------------------------------------
CREATE TABLE public.recados (
    id bigint NOT NULL,
    cuenta character varying(45) DEFAULT NULL::character varying,
    recado text,
    fecha timestamp with time zone,
    status character varying(45),
    updated_at timestamp with time zone,
    created_at timestamp with time zone,
    user_id bigint,
    tel_id bigint
);
ALTER TABLE public.recados OWNER TO fgonzalez;
CREATE SEQUENCE public.recados_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.recados_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.recados_id_seq OWNED BY public.recados.id;

----------------------------------------------------------------------
CREATE TABLE public.reports (
    user_id bigint NOT NULL,
    semana bigint,
    observaciones text,
    inconclusas bigint,
    autorized character varying(45) DEFAULT NULL::character varying,
    created_at character varying(45) DEFAULT NULL::character varying,
    updated_at character varying(45) DEFAULT NULL::character varying
);
ALTER TABLE public.reports OWNER TO fgonzalez;

----------------------------------------------------------------------
CREATE TABLE public.respuestas14 (
    registro bigint NOT NULL,
    aplica character varying(20) DEFAULT NULL::character varying,
    fec_capt timestamp with time zone,
    cuenta character varying(15) DEFAULT NULL::character varying,
    nombre character varying(50) DEFAULT NULL::character varying,
    paterno character varying(50) DEFAULT NULL::character varying,
    materno character varying(50) DEFAULT NULL::character varying,
    telcasa character varying(14) DEFAULT NULL::character varying,
    teltra character varying(14) DEFAULT NULL::character varying,
    exttra character varying(6) DEFAULT NULL::character varying,
    dianac smallint,
    mesnac smallint,
    yernac smallint,
    nar1 smallint,
    nar1_a character varying(50) DEFAULT NULL::character varying,
    nar2a smallint,
    nar3a smallint,
    nar4a smallint,
    nar5a smallint,
    nar7 smallint,
    nar8 smallint,
    nar9 smallint,
    nar10 character(2) DEFAULT NULL::bpchar,
    nar11 smallint,
    nar11a character varying(50) DEFAULT NULL::character varying,
    nar12 smallint,
    nar12a character varying(50) DEFAULT NULL::character varying,
    nar13 smallint,
    nar13a character varying(50) DEFAULT NULL::character varying,
    nar14 smallint,
    nar14otra character varying(50) DEFAULT NULL::character varying,
    nar15 smallint,
    nar15otra character varying(50) DEFAULT NULL::character varying,
    nar16 smallint,
    nar16otra character varying(50) DEFAULT NULL::character varying,
    nbr1 smallint,
    nbr2 character varying(50) DEFAULT NULL::character varying,
    nbr3 character varying(70) DEFAULT NULL::character varying,
    nbr3_a smallint,
    nbr6 character varying(4) DEFAULT NULL::character varying,
    nbr7 character varying(4) DEFAULT NULL::character varying,
    nbr8 smallint,
    ncr1 smallint,
    ncr2 character varying(80) DEFAULT NULL::character varying,
    ncr2a smallint,
    ncr3 smallint,
    ncr4 smallint,
    ncr4otra character varying(80) DEFAULT NULL::character varying,
    ncr5 smallint,
    ncr6 smallint,
    ncr6_a character varying(80) DEFAULT NULL::character varying,
    ncr7_a character varying(150) DEFAULT NULL::character varying,
    ncr7b smallint,
    ncr8 smallint,
    ncr9 smallint,
    ncr10 smallint,
    ncr11 smallint,
    ncr12_a character varying(201) DEFAULT NULL::character varying,
    ncr15 smallint,
    ncr16 smallint,
    ncr17 smallint,
    ncr18 smallint,
    ncr19 smallint,
    ncr20 smallint,
    ncr21 smallint,
    ncr21_a character varying(11) DEFAULT NULL::character varying,
    ncr21b smallint,
    ncr22 smallint,
    ncr23 smallint,
    ncr24 smallint,
    ncr24porque smallint,
    ncr24_a character varying(80) DEFAULT NULL::character varying,
    ndr1 smallint,
    ndr2 smallint,
    ndr2_a character varying(80) DEFAULT NULL::character varying,
    ndr3 smallint,
    ndr4 smallint,
    ndr5 smallint,
    ndr6 smallint,
    ndr9 smallint,
    ndr7 smallint,
    ndr8 smallint,
    ndr10 smallint,
    ndr11 smallint,
    ndr12 smallint,
    ndr13a character varying(60) DEFAULT NULL::character varying,
    ndr14 smallint,
    ndr15 smallint,
    ndr16 smallint,
    ndr17 smallint,
    ndr18 smallint,
    ndr19 smallint,
    ner1 smallint,
    ner2 smallint,
    ner3 smallint,
    ner4 smallint,
    ner5 smallint,
    ner6 smallint,
    ner7 smallint,
    ner7_a character varying(61) DEFAULT NULL::character varying,
    ner7int smallint,
    ner8 smallint,
    ner9 smallint,
    ner10 smallint,
    ner10a character varying(200) DEFAULT NULL::character varying,
    ner11 smallint,
    ner12 smallint,
    ner12a smallint,
    ner12b character varying(150) DEFAULT NULL::character varying,
    ner13 smallint,
    ner14 smallint,
    ner15 smallint,
    ner16 smallint,
    ner17 smallint,
    ner18 smallint,
    ner19 smallint,
    ner19a character varying(80) DEFAULT NULL::character varying,
    ner20 smallint,
    ner20txt character varying(50) DEFAULT NULL::character varying,
    ner20a smallint,
    nfr0 smallint,
    nfr1 smallint,
    nfr1a character varying(50) DEFAULT NULL::character varying,
    nfr2 smallint,
    nfr3 smallint,
    nfr7 smallint,
    nfr4 smallint,
    nfr4_a character varying(50) DEFAULT NULL::character varying,
    nfr5 smallint,
    nfr5_a character varying(80) DEFAULT NULL::character varying,
    nfr6 smallint,
    nfr6_a character varying(80) DEFAULT NULL::character varying,
    nfr8 smallint,
    nfr9 smallint,
    nfr10 smallint,
    nfr11 smallint,
    nfr11a character varying(80) DEFAULT NULL::character varying,
    nfr12 smallint,
    nfr13 smallint,
    nfr22 smallint,
    nfr23 smallint,
    nfr24 character varying(50) DEFAULT NULL::character varying,
    nfr25 smallint,
    nfr26 smallint,
    nfr27 smallint,
    nfr28 smallint,
    nfr29 smallint,
    nfr29a character varying(50) DEFAULT NULL::character varying,
    nfr30 smallint,
    nfr31 smallint,
    nfr32 smallint,
    nfr33 smallint,
    ngr1 smallint,
    ngr2 smallint,
    ngr3 smallint,
    ngr3b smallint,
    ngr3c smallint,
    ngr3d smallint,
    ngr3e smallint,
    ngr4 smallint,
    ngr5 smallint,
    ngr6 smallint,
    ngr6a smallint,
    ngr6b smallint,
    ngr6c smallint,
    ngr6d smallint,
    ngr6e smallint,
    ngr6f smallint,
    ngr6g smallint,
    ngr6_t character varying(50) DEFAULT NULL::character varying,
    ngr7a smallint,
    ngr7b smallint,
    ngr7c smallint,
    ngr7d smallint,
    ngr7e smallint,
    ngr7f smallint,
    ngr7g smallint,
    ngr8 smallint,
    ngr9a smallint,
    ngr9b smallint,
    ngr9c smallint,
    ngr9d smallint,
    ngr9e smallint,
    ngr11a smallint,
    ngr11 smallint,
    ngr11_a character varying(50) DEFAULT NULL::character varying,
    ngr13 smallint,
    ngr13b smallint,
    ngr13c smallint,
    ngr13d smallint,
    ngr13e smallint,
    ngr14 smallint,
    ngr15 smallint,
    ngr16 smallint,
    ngr17 smallint,
    ngr18 smallint,
    ngr19 smallint,
    ngr20 smallint,
    ngr21 smallint,
    ngr22 smallint,
    ngr23 smallint,
    ngr24 smallint,
    ngr25 smallint,
    ngr26 smallint,
    ngr27 smallint,
    ngr28 smallint,
    ngr29 smallint,
    ngr30 smallint,
    ngr31 smallint,
    ngr32 smallint,
    ngr33 smallint,
    ngr34 smallint,
    ngr35 smallint,
    ngr36 smallint,
    ngr37 smallint,
    ngr37m smallint,
    ngr37_a smallint,
    ngr38 smallint,
    ngr39 smallint,
    ngr40 smallint,
    ngr40a smallint,
    ngr40_a character varying(50) DEFAULT NULL::character varying,
    ngr40_b smallint,
    ngr41 smallint,
    ngr42 smallint,
    ngr43 smallint,
    ngr44 smallint,
    ngr45 smallint,
    ngr45_a smallint,
    ngr45otra character varying(50) DEFAULT NULL::character varying,
    ncra20 smallint,
    nrxx character varying(50) DEFAULT NULL::character varying,
    bach bigint,
    carrera character varying(45) DEFAULT NULL::character varying,
    plantel character varying(100) DEFAULT NULL::character varying,
    ngr13a smallint,
    fecha_anterior date,
    gen bigint,
    updated_at timestamp with time zone,
    status bigint,
    recado text,
    llamadas bigint
);
ALTER TABLE public.respuestas14 OWNER TO fgonzalez;
CREATE SEQUENCE public.respuestas14_registro_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.respuestas14_registro_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.respuestas14_registro_seq OWNED BY public.respuestas14.registro;

----------------------------------------------------------------------
CREATE TABLE public.respuestas20 (
    registro bigint NOT NULL,
    aplica character varying(20) DEFAULT NULL::character varying,
    aplica2 character varying(30) DEFAULT NULL::character varying,
    fec_capt timestamp with time zone,
    fec_capt2 timestamp with time zone,
    cuenta character varying(15) DEFAULT NULL::character varying,
    nombre character varying(50) DEFAULT NULL::character varying,
    paterno character varying(50) DEFAULT NULL::character varying,
    materno character varying(50) DEFAULT NULL::character varying,
    telcasa character varying(14) DEFAULT NULL::character varying,
    telcel character varying(25) DEFAULT NULL::character varying,
    teltra character varying(14) DEFAULT NULL::character varying,
    exttra character varying(6) DEFAULT NULL::character varying,
    dianac smallint,
    mesnac smallint,
    yernac smallint,
    nar1 smallint,
    nar1_a character varying(50) DEFAULT NULL::character varying,
    nar2a smallint,
    nar3a smallint,
    nar4a smallint,
    nar5a smallint,
    nar7 smallint,
    nar8 smallint,
    nar9 smallint,
    nar10 character(2) DEFAULT NULL::bpchar,
    nar11 smallint,
    nar11a character varying(50) DEFAULT NULL::character varying,
    nar12 smallint,
    nar12a character varying(50) DEFAULT NULL::character varying,
    nar13 smallint,
    nar13a character varying(50) DEFAULT NULL::character varying,
    nar14 smallint,
    nar14otra character varying(100) DEFAULT NULL::character varying,
    nar15 smallint,
    nar15otra character varying(100) DEFAULT NULL::character varying,
    nar16 smallint,
    nar16otra character varying(100) DEFAULT NULL::character varying,
    nbr1 smallint,
    nbr2 character varying(50) DEFAULT NULL::character varying,
    nbr3 character varying(70) DEFAULT NULL::character varying,
    nbr3_a smallint,
    nbr6 character varying(4) DEFAULT NULL::character varying,
    nbr7 character varying(4) DEFAULT NULL::character varying,
    nbr8 smallint,
    ncr1 smallint,
    ncr2 character varying(230) DEFAULT NULL::character varying,
    ncr2a smallint,
    ncr3 smallint,
    ncr4 smallint,
    ncr4otra character varying(100) DEFAULT NULL::character varying,
    ncr5 smallint,
    ncr6 smallint,
    ncr6_a character varying(100) DEFAULT NULL::character varying,
    ncr7_a character varying(200) DEFAULT NULL::character varying,
    ncr7b smallint,
    ncr8 smallint,
    ncr9 smallint,
    ncr10 smallint,
    ncr11 smallint,
    ncr12_a character varying(255) DEFAULT NULL::character varying,
    ncr15 smallint,
    ncr16 smallint,
    ncr17 smallint,
    ncr18 smallint,
    ncr19 smallint,
    ncr20 smallint,
    ncr21 bigint,
    ncr21_a character varying(11) DEFAULT NULL::character varying,
    ncr21b smallint,
    ncr22 smallint,
    ncr23 smallint,
    ncr24 smallint,
    ncr24porque smallint,
    ncr24_a character varying(100) DEFAULT NULL::character varying,
    ndr1 smallint,
    ndr2 smallint,
    ndr2_a character varying(100) DEFAULT NULL::character varying,
    ndr3 smallint,
    ndr4 smallint,
    ndr5 smallint,
    ndr6 smallint,
    ndr9 smallint,
    ndr7 smallint,
    ndr8 smallint,
    ndr10 smallint,
    ndr11 smallint,
    ndr12 smallint,
    ndr12a smallint,
    ndr12b smallint,
    ndr12c smallint,
    ndr13a character varying(100) DEFAULT NULL::character varying,
    ndr14 smallint,
    ndr15 smallint,
    ndr16 smallint,
    ndr17 smallint,
    ndr18 smallint,
    ndr19 smallint,
    ner1 smallint,
    ner1a smallint,
    ner2 smallint,
    ner3 smallint,
    ner4 smallint,
    ner5 smallint,
    ner6 smallint,
    ner7 smallint,
    ner7_a character varying(100) DEFAULT NULL::character varying,
    ner7int smallint,
    ner8 smallint,
    ner9 smallint,
    ner10 smallint,
    ner10a character varying(100) DEFAULT NULL::character varying,
    ner11 smallint,
    ner12 smallint,
    ner12a smallint,
    ner12b character varying(100) DEFAULT NULL::character varying,
    ner13 smallint,
    ner14 smallint,
    ner15 smallint,
    ner16 smallint,
    ner17 smallint,
    ner18 smallint,
    ner19 smallint,
    ner19a character varying(80) DEFAULT NULL::character varying,
    ner20 smallint,
    ner20txt character varying(200) DEFAULT NULL::character varying,
    ner20a smallint,
    nfr0 smallint,
    nfr1 smallint,
    nfr1a character varying(50) DEFAULT NULL::character varying,
    nfr2 smallint,
    nfr3 smallint,
    nfr7 smallint,
    nfr4 smallint,
    nfr4_a character varying(80) DEFAULT NULL::character varying,
    nfr5 smallint,
    nfr5_a character varying(100) DEFAULT NULL::character varying,
    nfr6 smallint,
    nfr6_a character varying(100) DEFAULT NULL::character varying,
    nfr8 smallint,
    nfr9 smallint,
    nfr10 smallint,
    nfr11 smallint,
    nfr11a character varying(255) DEFAULT NULL::character varying,
    nfr12 smallint,
    nfr13 smallint,
    nfr22 smallint,
    nfr23 smallint,
    nfr24 character varying(100) DEFAULT NULL::character varying,
    nfr25 smallint,
    nfr26 smallint,
    nfr27 smallint,
    nfr28 smallint,
    nfr29 smallint,
    nfr29a character varying(100) DEFAULT NULL::character varying,
    nfr30 smallint,
    nfr31 smallint,
    nfr32 smallint,
    nfr33 smallint,
    ngr1 smallint,
    ngr2 smallint,
    ngr3 smallint,
    ngr3b smallint,
    ngr3c smallint,
    ngr3d smallint,
    ngr3e smallint,
    ngr4 smallint,
    ngr5 smallint,
    ngr6 smallint,
    ngr6a smallint,
    ngr6b smallint,
    ngr6c smallint,
    ngr6d smallint,
    ngr6e smallint,
    ngr6f smallint,
    ngr6g smallint,
    ngr6_t character varying(50) DEFAULT NULL::character varying,
    ngr7a smallint,
    ngr7b smallint,
    ngr7c smallint,
    ngr7d smallint,
    ngr7e smallint,
    ngr7f smallint,
    ngr7g smallint,
    ngr8 smallint,
    ngr9a smallint,
    ngr9b smallint,
    ngr9c smallint,
    ngr9d smallint,
    ngr9e smallint,
    ngr11a smallint,
    ngr11 smallint,
    ngr11_a character varying(50) DEFAULT NULL::character varying,
    ngr13 smallint,
    ngr13b smallint,
    ngr13c smallint,
    ngr13d smallint,
    ngr13e smallint,
    ngr14 smallint,
    ngr15 smallint,
    ngr16 smallint,
    ngr17 smallint,
    ngr18 smallint,
    ngr19 smallint,
    ngr20 smallint,
    ngr21 smallint,
    ngr22 smallint,
    ngr23 smallint,
    ngr24 smallint,
    ngr25 smallint,
    ngr26 smallint,
    ngr27 smallint,
    ngr28 smallint,
    ngr29 smallint,
    ngr30 smallint,
    ngr31 smallint,
    ngr32 smallint,
    ngr33 smallint,
    ngr34 smallint,
    ngr35 smallint,
    ngr36 smallint,
    ngr37 smallint,
    ngr37m smallint,
    ngr37_a smallint,
    ngr38 smallint,
    ngr39 smallint,
    ngr40 smallint,
    ngr40a smallint,
    ngr40_a character varying(50) DEFAULT NULL::character varying,
    ngr40_b smallint,
    ngr41 smallint,
    ngr42 smallint,
    ngr43 smallint,
    ngr44 smallint,
    ngr45 smallint,
    ngr45_a smallint,
    ngr45otra character varying(100) DEFAULT NULL::character varying,
    conoce smallint,
    cue_cre smallint,
    utiliza smallint,
    nrx smallint,
    nrxx character varying(50) DEFAULT NULL::character varying,
    ngr11b integer,
    ngr11c integer,
    ngr11d integer,
    ngr11e integer,
    ngr11f integer,
    gen_dgae smallint,
    completed bigint DEFAULT '0'::bigint,
    created_at timestamp with time zone,
    updated_at timestamp with time zone,
    egresado_id bigint,
    carrera bigint,
    sec_a smallint,
    sec_e smallint,
    sec_f smallint,
    sec_d smallint,
    sec_g smallint,
    sec_c smallint,
    ncr2ext character varying(100) DEFAULT NULL::character varying,
    ner12ext character varying(100) DEFAULT NULL::character varying,
    ner15ext character varying(100) DEFAULT NULL::character varying,
    ner18ext character varying(100) DEFAULT NULL::character varying,
    ndr17a smallint,
    ngr40interes smallint,
    ngr40otro character varying(255) DEFAULT NULL::character varying,
    nfr23bin bigint
);
ALTER TABLE public.respuestas20 OWNER TO fgonzalez;
CREATE SEQUENCE public.respuestas20_registro_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.respuestas20_registro_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.respuestas20_registro_seq OWNED BY public.respuestas20.registro;

----------------------------------------------------------------------
CREATE TABLE public.respuestas20_resp (
    registro bigint NOT NULL,
    aplica character varying(20) DEFAULT NULL::character varying,
    aplica2 character varying(30) DEFAULT NULL::character varying,
    fec_capt timestamp with time zone,
    fec_capt2 timestamp with time zone,
    cuenta character varying(15) DEFAULT NULL::character varying,
    nombre character varying(50) DEFAULT NULL::character varying,
    paterno character varying(50) DEFAULT NULL::character varying,
    materno character varying(50) DEFAULT NULL::character varying,
    telcasa character varying(14) DEFAULT NULL::character varying,
    telcel character varying(25) DEFAULT NULL::character varying,
    teltra character varying(14) DEFAULT NULL::character varying,
    exttra character varying(6) DEFAULT NULL::character varying,
    dianac smallint,
    mesnac smallint,
    yernac smallint,
    nar1 smallint,
    nar1_a character varying(50) DEFAULT NULL::character varying,
    nar2a smallint,
    nar3a smallint,
    nar4a smallint,
    nar5a smallint,
    nar7 smallint,
    nar8 smallint,
    nar9 smallint,
    nar10 character(2) DEFAULT NULL::bpchar,
    nar11 smallint,
    nar11a character varying(50) DEFAULT NULL::character varying,
    nar12 smallint,
    nar12a character varying(50) DEFAULT NULL::character varying,
    nar13 smallint,
    nar13a character varying(50) DEFAULT NULL::character varying,
    nar14 smallint,
    nar14otra character varying(100) DEFAULT NULL::character varying,
    nar15 smallint,
    nar15otra character varying(100) DEFAULT NULL::character varying,
    nar16 smallint,
    nar16otra character varying(100) DEFAULT NULL::character varying,
    nbr1 smallint,
    nbr2 character varying(50) DEFAULT NULL::character varying,
    nbr3 character varying(70) DEFAULT NULL::character varying,
    nbr3_a smallint,
    nbr6 character varying(4) DEFAULT NULL::character varying,
    nbr7 character varying(4) DEFAULT NULL::character varying,
    nbr8 smallint,
    ncr1 smallint,
    ncr2 character varying(230) DEFAULT NULL::character varying,
    ncr2a smallint,
    ncr3 smallint,
    ncr4 smallint,
    ncr4otra character varying(100) DEFAULT NULL::character varying,
    ncr5 smallint,
    ncr6 smallint,
    ncr6_a character varying(100) DEFAULT NULL::character varying,
    ncr7_a character varying(200) DEFAULT NULL::character varying,
    ncr7b smallint,
    ncr8 smallint,
    ncr9 smallint,
    ncr10 smallint,
    ncr11 smallint,
    ncr12_a character varying(255) DEFAULT NULL::character varying,
    ncr15 smallint,
    ncr16 smallint,
    ncr17 smallint,
    ncr18 smallint,
    ncr19 smallint,
    ncr20 smallint,
    ncr21 bigint,
    ncr21_a character varying(11) DEFAULT NULL::character varying,
    ncr21b smallint,
    ncr22 smallint,
    ncr23 smallint,
    ncr24 smallint,
    ncr24porque smallint,
    ncr24_a character varying(100) DEFAULT NULL::character varying,
    ndr1 smallint,
    ndr2 smallint,
    ndr2_a character varying(100) DEFAULT NULL::character varying,
    ndr3 smallint,
    ndr4 smallint,
    ndr5 smallint,
    ndr6 smallint,
    ndr9 smallint,
    ndr7 smallint,
    ndr8 smallint,
    ndr10 smallint,
    ndr11 smallint,
    ndr12 smallint,
    ndr12a smallint,
    ndr12b smallint,
    ndr12c smallint,
    ndr13a character varying(100) DEFAULT NULL::character varying,
    ndr14 smallint,
    ndr15 smallint,
    ndr16 smallint,
    ndr17 smallint,
    ndr18 smallint,
    ndr19 smallint,
    ner1 smallint,
    ner1a smallint,
    ner2 smallint,
    ner3 smallint,
    ner4 smallint,
    ner5 smallint,
    ner6 smallint,
    ner7 smallint,
    ner7_a character varying(100) DEFAULT NULL::character varying,
    ner7int smallint,
    ner8 smallint,
    ner9 smallint,
    ner10 smallint,
    ner10a character varying(100) DEFAULT NULL::character varying,
    ner11 smallint,
    ner12 smallint,
    ner12a smallint,
    ner12b character varying(100) DEFAULT NULL::character varying,
    ner13 smallint,
    ner14 smallint,
    ner15 smallint,
    ner16 smallint,
    ner17 smallint,
    ner18 smallint,
    ner19 smallint,
    ner19a character varying(80) DEFAULT NULL::character varying,
    ner20 smallint,
    ner20txt character varying(200) DEFAULT NULL::character varying,
    ner20a smallint,
    nfr0 smallint,
    nfr1 smallint,
    nfr1a character varying(80) DEFAULT NULL::character varying,
    nfr2 smallint,
    nfr3 smallint,
    nfr7 smallint,
    nfr4 smallint,
    nfr4_a character varying(80) DEFAULT NULL::character varying,
    nfr5 smallint,
    nfr5_a character varying(100) DEFAULT NULL::character varying,
    nfr6 smallint,
    nfr6_a character varying(100) DEFAULT NULL::character varying,
    nfr8 smallint,
    nfr9 smallint,
    nfr10 smallint,
    nfr11 smallint,
    nfr11a character varying(255) DEFAULT NULL::character varying,
    nfr12 smallint,
    nfr13 smallint,
    nfr22 smallint,
    nfr23 smallint,
    nfr24 character varying(100) DEFAULT NULL::character varying,
    nfr25 smallint,
    nfr26 smallint,
    nfr27 smallint,
    nfr28 smallint,
    nfr29 smallint,
    nfr29a character varying(100) DEFAULT NULL::character varying,
    nfr30 smallint,
    nfr31 smallint,
    nfr32 smallint,
    nfr33 smallint,
    ngr1 smallint,
    ngr2 smallint,
    ngr3 smallint,
    ngr3b smallint,
    ngr3c smallint,
    ngr3d smallint,
    ngr3e smallint,
    ngr4 smallint,
    ngr5 smallint,
    ngr6 smallint,
    ngr6a smallint,
    ngr6b smallint,
    ngr6c smallint,
    ngr6d smallint,
    ngr6e smallint,
    ngr6f smallint,
    ngr6g smallint,
    ngr6_t character varying(50) DEFAULT NULL::character varying,
    ngr7a smallint,
    ngr7b smallint,
    ngr7c smallint,
    ngr7d smallint,
    ngr7e smallint,
    ngr7f smallint,
    ngr7g smallint,
    ngr8 smallint,
    ngr9a smallint,
    ngr9b smallint,
    ngr9c smallint,
    ngr9d smallint,
    ngr9e smallint,
    ngr11a smallint,
    ngr11 smallint,
    ngr11_a character varying(50) DEFAULT NULL::character varying,
    ngr13 smallint,
    ngr13b smallint,
    ngr13c smallint,
    ngr13d smallint,
    ngr13e smallint,
    ngr14 smallint,
    ngr15 smallint,
    ngr16 smallint,
    ngr17 smallint,
    ngr18 smallint,
    ngr19 smallint,
    ngr20 smallint,
    ngr21 smallint,
    ngr22 smallint,
    ngr23 smallint,
    ngr24 smallint,
    ngr25 smallint,
    ngr26 smallint,
    ngr27 smallint,
    ngr28 smallint,
    ngr29 smallint,
    ngr30 smallint,
    ngr31 smallint,
    ngr32 smallint,
    ngr33 smallint,
    ngr34 smallint,
    ngr35 smallint,
    ngr36 smallint,
    ngr37 smallint,
    ngr37m smallint,
    ngr37_a smallint,
    ngr38 smallint,
    ngr39 smallint,
    ngr40 smallint,
    ngr40a smallint,
    ngr40_a character varying(50) DEFAULT NULL::character varying,
    ngr40_b smallint,
    ngr41 smallint,
    ngr42 smallint,
    ngr43 smallint,
    ngr44 smallint,
    ngr45 smallint,
    ngr45_a smallint,
    ngr45otra character varying(100) DEFAULT NULL::character varying,
    conoce smallint,
    cue_cre smallint,
    utiliza smallint,
    nrx smallint,
    nrxx character varying(50) DEFAULT NULL::character varying,
    ngr11b integer,
    ngr11c integer,
    ngr11d integer,
    ngr11e integer,
    ngr11f integer,
    gen_dgae smallint,
    completed bigint DEFAULT '0'::bigint,
    created_at timestamp with time zone,
    updated_at timestamp with time zone,
    egresado_id bigint,
    carrera bigint,
    sec_g smallint,
    sec_d smallint,
    sec_c smallint,
    ncr2ext character varying(100) DEFAULT NULL::character varying,
    ner12ext character varying(100) DEFAULT NULL::character varying,
    ner15ext character varying(100) DEFAULT NULL::character varying,
    ner18ext character varying(100) DEFAULT NULL::character varying,
    sec_f smallint,
    sec_e smallint,
    sec_a smallint,
    ndr17a smallint,
    ngr40interes smallint,
    ngr40otro character varying(255) DEFAULT NULL::character varying,
    nfr23bin bigint
);
ALTER TABLE public.respuestas20_resp OWNER TO fgonzalez;
CREATE SEQUENCE public.respuestas20_resp_registro_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.respuestas20_resp_registro_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.respuestas20_resp_registro_seq OWNED BY public.respuestas20_resp.registro;


----------------------------------------------------------------------
CREATE TABLE public.telefonos (
    id bigint NOT NULL,
    cuenta character varying,
    telefono character varying(45) DEFAULT NULL::character varying,
    status character varying(45) DEFAULT NULL::character varying,
    updated_at date,
    created_at date,
    descripcion character varying(255) DEFAULT NULL::character varying
);
ALTER TABLE public.telefonos OWNER TO fgonzalez;
CREATE SEQUENCE public.telefonos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.telefonos_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.telefonos_id_seq OWNED BY public.telefonos.id;

----------------------------------------------------------------------
CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp with time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100) DEFAULT NULL::character varying,
    created_at timestamp with time zone,
    updated_at timestamp with time zone,
    emojis character varying(10) DEFAULT NULL::character varying,
    color character varying(20) DEFAULT NULL::character varying,
    clave character varying(20),
    image character varying(30) DEFAULT NULL::character varying,
    dark_mode bigint DEFAULT '0'::bigint,
    confidential smallint DEFAULT '0'::smallint
);
ALTER TABLE public.users OWNER TO fgonzalez;
CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
ALTER TABLE public.users_id_seq OWNER TO fgonzalez;
ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;

----------------------------------------------------------------------
----------------------------------------------------------------------
----------------------------------------------------------------------

ALTER TABLE ONLY public.admin_menu ALTER COLUMN id SET DEFAULT nextval('public.admin_menu_id_seq'::regclass);
ALTER TABLE ONLY public.admin_operation_log ALTER COLUMN id SET DEFAULT nextval('public.admin_operation_log_id_seq'::regclass);
ALTER TABLE ONLY public.admin_permissions ALTER COLUMN id SET DEFAULT nextval('public.admin_permissions_id_seq'::regclass);
ALTER TABLE ONLY public.admin_roles ALTER COLUMN id SET DEFAULT nextval('public.admin_roles_id_seq'::regclass);
ALTER TABLE ONLY public.admin_users ALTER COLUMN id SET DEFAULT nextval('public.admin_users_id_seq'::regclass);
ALTER TABLE ONLY public.bloqueos ALTER COLUMN id SET DEFAULT nextval('public.bloqueos_id_seq'::regclass);
ALTER TABLE ONLY public.carreras ALTER COLUMN id SET DEFAULT nextval('public.carreras_id_seq'::regclass);
ALTER TABLE ONLY public.correos ALTER COLUMN id SET DEFAULT nextval('public.correos_id_seq'::regclass);
ALTER TABLE ONLY public.egresados ALTER COLUMN id SET DEFAULT nextval('public.egresados_id_seq'::regclass);
ALTER TABLE ONLY public.estudios ALTER COLUMN id SET DEFAULT nextval('public.estudios_id_seq'::regclass);
ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);
ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);
ALTER TABLE ONLY public.muestras ALTER COLUMN id SET DEFAULT nextval('public.muestras_id_seq'::regclass);
ALTER TABLE ONLY public.multiple_option_answers ALTER COLUMN id SET DEFAULT nextval('public.multiple_option_answers_id_seq'::regclass);
ALTER TABLE ONLY public.options ALTER COLUMN id SET DEFAULT nextval('public.options_id_seq'::regclass);
ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);
ALTER TABLE ONLY public.reactivos ALTER COLUMN id SET DEFAULT nextval('public.reactivos_id_seq'::regclass);
ALTER TABLE ONLY public.recados ALTER COLUMN id SET DEFAULT nextval('public.recados_id_seq'::regclass);
ALTER TABLE ONLY public.respuestas14 ALTER COLUMN registro SET DEFAULT nextval('public.respuestas14_registro_seq'::regclass);
ALTER TABLE ONLY public.respuestas20 ALTER COLUMN registro SET DEFAULT nextval('public.respuestas20_registro_seq'::regclass);
ALTER TABLE ONLY public.respuestas20_resp ALTER COLUMN registro SET DEFAULT nextval('public.respuestas20_resp_registro_seq'::regclass);
ALTER TABLE ONLY public.telefonos ALTER COLUMN id SET DEFAULT nextval('public.telefonos_id_seq'::regclass);
ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);
ALTER TABLE ONLY public.admin_menu
    ADD CONSTRAINT idx_25981_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.admin_operation_log
    ADD CONSTRAINT idx_25992_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.admin_permissions
    ADD CONSTRAINT idx_25999_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.admin_roles
    ADD CONSTRAINT idx_26007_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.admin_users
    ADD CONSTRAINT idx_26021_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.bloqueos
    ADD CONSTRAINT idx_26033_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.carreras
    ADD CONSTRAINT idx_26090_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.codigos
    ADD CONSTRAINT idx_26096_primary PRIMARY KEY (code);
ALTER TABLE ONLY public.comentario
    ADD CONSTRAINT idx_26104_primary PRIMARY KEY (registro);
ALTER TABLE ONLY public.correos
    ADD CONSTRAINT idx_26119_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.egresados
    ADD CONSTRAINT idx_26131_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.encuestador_muestra
    ADD CONSTRAINT idx_26204_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.estudios
    ADD CONSTRAINT idx_26208_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT idx_26216_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT idx_26229_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.muestras
    ADD CONSTRAINT idx_26234_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.multiple_option_answers
    ADD CONSTRAINT idx_26239_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.options
    ADD CONSTRAINT idx_26293_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT idx_26305_primary PRIMARY KEY (email);
ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT idx_26311_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.reactivos
    ADD CONSTRAINT idx_26402_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.recados
    ADD CONSTRAINT idx_26417_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.reports
    ADD CONSTRAINT idx_26424_primary PRIMARY KEY (user_id);
ALTER TABLE ONLY public.respuestas14
    ADD CONSTRAINT idx_26539_primary PRIMARY KEY (registro);
ALTER TABLE ONLY public.respuestas20
    ADD CONSTRAINT idx_26650_primary PRIMARY KEY (registro);
ALTER TABLE ONLY public.respuestas20_resp
    ADD CONSTRAINT idx_26711_primary PRIMARY KEY (registro);
ALTER TABLE ONLY public.telefonos
    ADD CONSTRAINT idx_26811_primary PRIMARY KEY (id);
ALTER TABLE ONLY public.users
    ADD CONSTRAINT idx_26837_primary PRIMARY KEY (id);
CREATE INDEX idx_25992_admin_operation_log_user_id_index ON public.admin_operation_log USING btree (user_id);
CREATE UNIQUE INDEX idx_25999_admin_permissions_name_unique ON public.admin_permissions USING btree (name);
CREATE UNIQUE INDEX idx_25999_admin_permissions_slug_unique ON public.admin_permissions USING btree (slug);
CREATE UNIQUE INDEX idx_26007_admin_roles_name_unique ON public.admin_roles USING btree (name);
CREATE UNIQUE INDEX idx_26007_admin_roles_slug_unique ON public.admin_roles USING btree (slug);
CREATE INDEX idx_26011_admin_role_menu_role_id_menu_id_index ON public.admin_role_menu USING btree (role_id, menu_id);
CREATE INDEX idx_26014_admin_role_permissions_role_id_permission_id_index ON public.admin_role_permissions USING btree (role_id, permission_id);
CREATE INDEX idx_26017_admin_role_users_role_id_user_id_index ON public.admin_role_users USING btree (role_id, user_id);
CREATE UNIQUE INDEX idx_26021_admin_users_username_unique ON public.admin_users USING btree (username);
CREATE INDEX idx_26029_admin_user_permissions_user_id_permission_id_index ON public.admin_user_permissions USING btree (user_id, permission_id);
CREATE UNIQUE INDEX idx_26216_failed_jobs_uuid_unique ON public.failed_jobs USING btree (uuid);
CREATE INDEX idx_26300_password_resets_email_index ON public.password_resets USING btree (email);
CREATE UNIQUE INDEX idx_26311_personal_access_tokens_token_unique ON public.personal_access_tokens USING btree (token);
CREATE INDEX idx_26311_personal_access_tokens_tokenable_type_tokenable_id_in ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);
CREATE UNIQUE INDEX idx_26837_users_email_unique ON public.users USING btree (email);
REVOKE USAGE ON SCHEMA public FROM PUBLIC;

--
-- PostgreSQL database dump complete
--

