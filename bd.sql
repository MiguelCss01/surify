--
-- PostgreSQL database dump
--


-- Dumped from database version 18.4
-- Dumped by pg_dump version 18.4

-- Started on 2026-06-16 01:59:09

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

--
-- TOC entry 2 (class 3079 OID 27521)
-- Name: postgis; Type: EXTENSION; Schema: -; Owner: -
--

CREATE EXTENSION IF NOT EXISTS postgis WITH SCHEMA public;


--
-- TOC entry 6165 (class 0 OID 0)
-- Dependencies: 2
-- Name: EXTENSION postgis; Type: COMMENT; Schema: -; Owner: -
--

COMMENT ON EXTENSION postgis IS 'PostGIS geometry and geography spatial types and functions';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 225 (class 1259 OID 28603)
-- Name: cache; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration bigint NOT NULL
);


--
-- TOC entry 226 (class 1259 OID 28611)
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration bigint NOT NULL
);


--
-- TOC entry 227 (class 1259 OID 28619)
-- Name: configuraciones; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.configuraciones (
    id bigint NOT NULL,
    clave character varying(255) NOT NULL,
    valor numeric(10,2) NOT NULL,
    descripcion text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 228 (class 1259 OID 28627)
-- Name: configuraciones_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.configuraciones_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6166 (class 0 OID 0)
-- Dependencies: 228
-- Name: configuraciones_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.configuraciones_id_seq OWNED BY public.configuraciones.id;


--
-- TOC entry 229 (class 1259 OID 28628)
-- Name: destinos; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.destinos (
    id bigint NOT NULL,
    provincia_id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    descripcion text NOT NULL,
    rango_precio character varying(255) NOT NULL,
    categoria character varying(255),
    ubicacion public.geometry,
    imagen_url character varying(255),
    activo boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 230 (class 1259 OID 28640)
-- Name: destinos_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.destinos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6167 (class 0 OID 0)
-- Dependencies: 230
-- Name: destinos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.destinos_id_seq OWNED BY public.destinos.id;


--
-- TOC entry 231 (class 1259 OID 28641)
-- Name: destinos_visitados; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.destinos_visitados (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    destino_id bigint NOT NULL,
    visitado_en date,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 232 (class 1259 OID 28647)
-- Name: destinos_visitados_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.destinos_visitados_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6168 (class 0 OID 0)
-- Dependencies: 232
-- Name: destinos_visitados_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.destinos_visitados_id_seq OWNED BY public.destinos_visitados.id;


--
-- TOC entry 267 (class 1259 OID 29005)
-- Name: evento_favoritos; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.evento_favoritos (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    evento_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 266 (class 1259 OID 29004)
-- Name: evento_favoritos_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.evento_favoritos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6169 (class 0 OID 0)
-- Dependencies: 266
-- Name: evento_favoritos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.evento_favoritos_id_seq OWNED BY public.evento_favoritos.id;


--
-- TOC entry 269 (class 1259 OID 29027)
-- Name: evento_visitados; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.evento_visitados (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    evento_id bigint NOT NULL,
    visitado_en date,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 268 (class 1259 OID 29026)
-- Name: evento_visitados_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.evento_visitados_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6170 (class 0 OID 0)
-- Dependencies: 268
-- Name: evento_visitados_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.evento_visitados_id_seq OWNED BY public.evento_visitados.id;


--
-- TOC entry 233 (class 1259 OID 28648)
-- Name: eventos; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.eventos (
    id bigint NOT NULL,
    provincia_id bigint NOT NULL,
    destino_id bigint,
    nombre character varying(255) NOT NULL,
    tipo character varying(255) NOT NULL,
    fecha_inicio date NOT NULL,
    fecha_fin date,
    ubicacion public.geometry,
    rango_precio character varying(255),
    imagen_url character varying(255),
    activo boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    descripcion text,
    sugerido_por bigint
);


--
-- TOC entry 234 (class 1259 OID 28660)
-- Name: eventos_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.eventos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6171 (class 0 OID 0)
-- Dependencies: 234
-- Name: eventos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.eventos_id_seq OWNED BY public.eventos.id;


--
-- TOC entry 235 (class 1259 OID 28661)
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection character varying(255) NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


--
-- TOC entry 236 (class 1259 OID 28674)
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6172 (class 0 OID 0)
-- Dependencies: 236
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- TOC entry 237 (class 1259 OID 28675)
-- Name: favoritos; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.favoritos (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    destino_id bigint,
    evento_id bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 238 (class 1259 OID 28680)
-- Name: favoritos_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.favoritos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6173 (class 0 OID 0)
-- Dependencies: 238
-- Name: favoritos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.favoritos_id_seq OWNED BY public.favoritos.id;


--
-- TOC entry 239 (class 1259 OID 28681)
-- Name: gastronomia; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.gastronomia (
    id bigint NOT NULL,
    provincia_id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    descripcion text NOT NULL,
    categoria character varying(255) NOT NULL,
    imagen_url character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 240 (class 1259 OID 28691)
-- Name: gastronomia_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.gastronomia_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6174 (class 0 OID 0)
-- Dependencies: 240
-- Name: gastronomia_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.gastronomia_id_seq OWNED BY public.gastronomia.id;


--
-- TOC entry 241 (class 1259 OID 28692)
-- Name: imagenes_resenas; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.imagenes_resenas (
    id bigint NOT NULL,
    resena_id bigint NOT NULL,
    url character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 242 (class 1259 OID 28698)
-- Name: imagenes_resenas_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.imagenes_resenas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6175 (class 0 OID 0)
-- Dependencies: 242
-- Name: imagenes_resenas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.imagenes_resenas_id_seq OWNED BY public.imagenes_resenas.id;


--
-- TOC entry 243 (class 1259 OID 28699)
-- Name: job_batches; Type: TABLE; Schema: public; Owner: -
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


--
-- TOC entry 244 (class 1259 OID 28711)
-- Name: jobs; Type: TABLE; Schema: public; Owner: -
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


--
-- TOC entry 245 (class 1259 OID 28722)
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6176 (class 0 OID 0)
-- Dependencies: 245
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- TOC entry 246 (class 1259 OID 28723)
-- Name: migrations; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


--
-- TOC entry 247 (class 1259 OID 28729)
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6177 (class 0 OID 0)
-- Dependencies: 247
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- TOC entry 248 (class 1259 OID 28730)
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


--
-- TOC entry 249 (class 1259 OID 28737)
-- Name: permisos; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.permisos (
    id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    descripcion text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 250 (class 1259 OID 28744)
-- Name: permisos_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.permisos_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6178 (class 0 OID 0)
-- Dependencies: 250
-- Name: permisos_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.permisos_id_seq OWNED BY public.permisos.id;


--
-- TOC entry 265 (class 1259 OID 28986)
-- Name: provincia_imagenes; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.provincia_imagenes (
    id bigint NOT NULL,
    provincia_id bigint NOT NULL,
    url character varying(255) NOT NULL,
    descripcion character varying(255),
    orden integer DEFAULT 0 NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 264 (class 1259 OID 28985)
-- Name: provincia_imagenes_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.provincia_imagenes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6179 (class 0 OID 0)
-- Dependencies: 264
-- Name: provincia_imagenes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.provincia_imagenes_id_seq OWNED BY public.provincia_imagenes.id;


--
-- TOC entry 251 (class 1259 OID 28745)
-- Name: provincias; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.provincias (
    id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    descripcion text,
    imagen_url character varying(255),
    region character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 252 (class 1259 OID 28752)
-- Name: provincias_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.provincias_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6180 (class 0 OID 0)
-- Dependencies: 252
-- Name: provincias_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.provincias_id_seq OWNED BY public.provincias.id;


--
-- TOC entry 253 (class 1259 OID 28753)
-- Name: resenas; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.resenas (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    destino_id bigint,
    evento_id bigint,
    calificacion integer NOT NULL,
    titulo character varying(255),
    comentario text NOT NULL,
    anonima boolean DEFAULT false NOT NULL,
    aprobada boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 254 (class 1259 OID 28766)
-- Name: resenas_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.resenas_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6181 (class 0 OID 0)
-- Dependencies: 254
-- Name: resenas_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.resenas_id_seq OWNED BY public.resenas.id;


--
-- TOC entry 255 (class 1259 OID 28767)
-- Name: role_permiso; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.role_permiso (
    id bigint NOT NULL,
    role_id bigint NOT NULL,
    permiso_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 256 (class 1259 OID 28773)
-- Name: role_permiso_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.role_permiso_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6182 (class 0 OID 0)
-- Dependencies: 256
-- Name: role_permiso_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.role_permiso_id_seq OWNED BY public.role_permiso.id;


--
-- TOC entry 257 (class 1259 OID 28774)
-- Name: role_user; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.role_user (
    id bigint NOT NULL,
    user_id bigint NOT NULL,
    role_id bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 258 (class 1259 OID 28780)
-- Name: role_user_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.role_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6183 (class 0 OID 0)
-- Dependencies: 258
-- Name: role_user_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.role_user_id_seq OWNED BY public.role_user.id;


--
-- TOC entry 259 (class 1259 OID 28781)
-- Name: roles; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.roles (
    id bigint NOT NULL,
    nombre character varying(255) NOT NULL,
    descripcion text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 260 (class 1259 OID 28788)
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6184 (class 0 OID 0)
-- Dependencies: 260
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- TOC entry 261 (class 1259 OID 28789)
-- Name: sessions; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


--
-- TOC entry 262 (class 1259 OID 28797)
-- Name: users; Type: TABLE; Schema: public; Owner: -
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255),
    google_id character varying(255),
    avatar character varying(255),
    biografia text,
    remember_token character varying(100),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


--
-- TOC entry 263 (class 1259 OID 28805)
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: -
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- TOC entry 6185 (class 0 OID 0)
-- Dependencies: 263
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: -
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- TOC entry 5837 (class 2604 OID 28806)
-- Name: configuraciones id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.configuraciones ALTER COLUMN id SET DEFAULT nextval('public.configuraciones_id_seq'::regclass);


--
-- TOC entry 5838 (class 2604 OID 28807)
-- Name: destinos id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.destinos ALTER COLUMN id SET DEFAULT nextval('public.destinos_id_seq'::regclass);


--
-- TOC entry 5840 (class 2604 OID 28808)
-- Name: destinos_visitados id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.destinos_visitados ALTER COLUMN id SET DEFAULT nextval('public.destinos_visitados_id_seq'::regclass);


--
-- TOC entry 5861 (class 2604 OID 29008)
-- Name: evento_favoritos id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evento_favoritos ALTER COLUMN id SET DEFAULT nextval('public.evento_favoritos_id_seq'::regclass);


--
-- TOC entry 5862 (class 2604 OID 29030)
-- Name: evento_visitados id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evento_visitados ALTER COLUMN id SET DEFAULT nextval('public.evento_visitados_id_seq'::regclass);


--
-- TOC entry 5841 (class 2604 OID 28809)
-- Name: eventos id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.eventos ALTER COLUMN id SET DEFAULT nextval('public.eventos_id_seq'::regclass);


--
-- TOC entry 5843 (class 2604 OID 28810)
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- TOC entry 5845 (class 2604 OID 28811)
-- Name: favoritos id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.favoritos ALTER COLUMN id SET DEFAULT nextval('public.favoritos_id_seq'::regclass);


--
-- TOC entry 5846 (class 2604 OID 28812)
-- Name: gastronomia id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.gastronomia ALTER COLUMN id SET DEFAULT nextval('public.gastronomia_id_seq'::regclass);


--
-- TOC entry 5847 (class 2604 OID 28813)
-- Name: imagenes_resenas id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.imagenes_resenas ALTER COLUMN id SET DEFAULT nextval('public.imagenes_resenas_id_seq'::regclass);


--
-- TOC entry 5848 (class 2604 OID 28814)
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- TOC entry 5849 (class 2604 OID 28815)
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- TOC entry 5850 (class 2604 OID 28816)
-- Name: permisos id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.permisos ALTER COLUMN id SET DEFAULT nextval('public.permisos_id_seq'::regclass);


--
-- TOC entry 5859 (class 2604 OID 28989)
-- Name: provincia_imagenes id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.provincia_imagenes ALTER COLUMN id SET DEFAULT nextval('public.provincia_imagenes_id_seq'::regclass);


--
-- TOC entry 5851 (class 2604 OID 28817)
-- Name: provincias id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.provincias ALTER COLUMN id SET DEFAULT nextval('public.provincias_id_seq'::regclass);


--
-- TOC entry 5852 (class 2604 OID 28818)
-- Name: resenas id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.resenas ALTER COLUMN id SET DEFAULT nextval('public.resenas_id_seq'::regclass);


--
-- TOC entry 5855 (class 2604 OID 28819)
-- Name: role_permiso id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.role_permiso ALTER COLUMN id SET DEFAULT nextval('public.role_permiso_id_seq'::regclass);


--
-- TOC entry 5856 (class 2604 OID 28820)
-- Name: role_user id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.role_user ALTER COLUMN id SET DEFAULT nextval('public.role_user_id_seq'::regclass);


--
-- TOC entry 5857 (class 2604 OID 28821)
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- TOC entry 5858 (class 2604 OID 28822)
-- Name: users id; Type: DEFAULT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- TOC entry 6115 (class 0 OID 28603)
-- Dependencies: 225
-- Data for Name: cache; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.cache VALUES ('laravel-cache-forecast_-34.6037_-58.3816', 'a:5:{s:3:"cod";s:3:"200";s:7:"message";i:0;s:3:"cnt";i:8;s:4:"list";a:8:{i:0;a:9:{s:2:"dt";i:1781535600;s:4:"main";a:9:{s:4:"temp";d:9.18;s:10:"feels_like";d:7.04;s:8:"temp_min";d:9.17;s:8:"temp_max";d:9.18;s:8:"pressure";i:1023;s:9:"sea_level";i:1023;s:10:"grnd_level";i:1022;s:8:"humidity";i:62;s:7:"temp_kf";d:0.01;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:802;s:4:"main";s:6:"Clouds";s:11:"description";s:15:"nubes dispersas";s:4:"icon";s:3:"03d";}}s:6:"clouds";a:1:{s:3:"all";i:34;}s:4:"wind";a:3:{s:5:"speed";d:3.91;s:3:"deg";i:296;s:4:"gust";d:5.31;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"d";}s:6:"dt_txt";s:19:"2026-06-15 15:00:00";}i:1;a:9:{s:2:"dt";i:1781546400;s:4:"main";a:9:{s:4:"temp";d:10.13;s:10:"feels_like";d:8.66;s:8:"temp_min";d:10.13;s:8:"temp_max";d:12.04;s:8:"pressure";i:1022;s:9:"sea_level";i:1022;s:10:"grnd_level";i:1020;s:8:"humidity";i:56;s:7:"temp_kf";d:-1.91;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:802;s:4:"main";s:6:"Clouds";s:11:"description";s:15:"nubes dispersas";s:4:"icon";s:3:"03d";}}s:6:"clouds";a:1:{s:3:"all";i:28;}s:4:"wind";a:3:{s:5:"speed";d:4.06;s:3:"deg";i:294;s:4:"gust";d:5.71;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"d";}s:6:"dt_txt";s:19:"2026-06-15 18:00:00";}i:2;a:9:{s:2:"dt";i:1781557200;s:4:"main";a:9:{s:4:"temp";d:10.93;s:10:"feels_like";d:9.54;s:8:"temp_min";d:10.93;s:8:"temp_max";d:11.8;s:8:"pressure";i:1021;s:9:"sea_level";i:1021;s:10:"grnd_level";i:1019;s:8:"humidity";i:56;s:7:"temp_kf";d:-0.87;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:801;s:4:"main";s:6:"Clouds";s:11:"description";s:13:"algo de nubes";s:4:"icon";s:3:"02n";}}s:6:"clouds";a:1:{s:3:"all";i:11;}s:4:"wind";a:3:{s:5:"speed";d:4.3;s:3:"deg";i:310;s:4:"gust";d:7.98;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"n";}s:6:"dt_txt";s:19:"2026-06-15 21:00:00";}i:3;a:9:{s:2:"dt";i:1781568000;s:4:"main";a:9:{s:4:"temp";d:10.71;s:10:"feels_like";d:9.46;s:8:"temp_min";d:10.71;s:8:"temp_max";d:10.71;s:8:"pressure";i:1020;s:9:"sea_level";i:1020;s:10:"grnd_level";i:1019;s:8:"humidity";i:62;s:7:"temp_kf";i:0;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:800;s:4:"main";s:5:"Clear";s:11:"description";s:11:"cielo claro";s:4:"icon";s:3:"01n";}}s:6:"clouds";a:1:{s:3:"all";i:0;}s:4:"wind";a:3:{s:5:"speed";d:5.22;s:3:"deg";i:315;s:4:"gust";d:10.67;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"n";}s:6:"dt_txt";s:19:"2026-06-16 00:00:00";}i:4;a:9:{s:2:"dt";i:1781578800;s:4:"main";a:9:{s:4:"temp";d:9.94;s:10:"feels_like";d:7.58;s:8:"temp_min";d:9.94;s:8:"temp_max";d:9.94;s:8:"pressure";i:1020;s:9:"sea_level";i:1020;s:10:"grnd_level";i:1019;s:8:"humidity";i:65;s:7:"temp_kf";i:0;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:800;s:4:"main";s:5:"Clear";s:11:"description";s:11:"cielo claro";s:4:"icon";s:3:"01n";}}s:6:"clouds";a:1:{s:3:"all";i:0;}s:4:"wind";a:3:{s:5:"speed";d:4.82;s:3:"deg";i:303;s:4:"gust";d:10.8;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"n";}s:6:"dt_txt";s:19:"2026-06-16 03:00:00";}i:5;a:9:{s:2:"dt";i:1781589600;s:4:"main";a:9:{s:4:"temp";d:9.44;s:10:"feels_like";d:6.75;s:8:"temp_min";d:9.44;s:8:"temp_max";d:9.44;s:8:"pressure";i:1019;s:9:"sea_level";i:1019;s:10:"grnd_level";i:1018;s:8:"humidity";i:69;s:7:"temp_kf";i:0;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:800;s:4:"main";s:5:"Clear";s:11:"description";s:11:"cielo claro";s:4:"icon";s:3:"01n";}}s:6:"clouds";a:1:{s:3:"all";i:0;}s:4:"wind";a:3:{s:5:"speed";d:5.37;s:3:"deg";i:304;s:4:"gust";d:11.43;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"n";}s:6:"dt_txt";s:19:"2026-06-16 06:00:00";}i:6;a:9:{s:2:"dt";i:1781600400;s:4:"main";a:9:{s:4:"temp";d:9.03;s:10:"feels_like";d:6.12;s:8:"temp_min";d:9.03;s:8:"temp_max";d:9.03;s:8:"pressure";i:1018;s:9:"sea_level";i:1018;s:10:"grnd_level";i:1017;s:8:"humidity";i:75;s:7:"temp_kf";i:0;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:800;s:4:"main";s:5:"Clear";s:11:"description";s:11:"cielo claro";s:4:"icon";s:3:"01n";}}s:6:"clouds";a:1:{s:3:"all";i:0;}s:4:"wind";a:3:{s:5:"speed";d:5.69;s:3:"deg";i:301;s:4:"gust";d:12.84;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"n";}s:6:"dt_txt";s:19:"2026-06-16 09:00:00";}i:7;a:9:{s:2:"dt";i:1781611200;s:4:"main";a:9:{s:4:"temp";d:9.03;s:10:"feels_like";i:6;s:8:"temp_min";d:9.03;s:8:"temp_max";d:9.03;s:8:"pressure";i:1018;s:9:"sea_level";i:1018;s:10:"grnd_level";i:1017;s:8:"humidity";i:78;s:7:"temp_kf";i:0;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:800;s:4:"main";s:5:"Clear";s:11:"description";s:11:"cielo claro";s:4:"icon";s:3:"01d";}}s:6:"clouds";a:1:{s:3:"all";i:0;}s:4:"wind";a:3:{s:5:"speed";d:6.03;s:3:"deg";i:302;s:4:"gust";d:13.44;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"d";}s:6:"dt_txt";s:19:"2026-06-16 12:00:00";}}s:4:"city";a:8:{s:2:"id";i:6693229;s:4:"name";s:11:"San Nicolas";s:5:"coord";a:2:{s:3:"lat";d:-34.6037;s:3:"lon";d:-58.3816;}s:7:"country";s:2:"AR";s:10:"population";i:0;s:8:"timezone";i:-10800;s:7:"sunrise";i:1781521120;s:6:"sunset";i:1781556568;}}', 1781535877);
INSERT INTO public.cache VALUES ('laravel-cache-weather_-41.1335_-71.3082', 'a:13:{s:5:"coord";a:2:{s:3:"lon";d:-71.3094;s:3:"lat";d:-41.1336;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:800;s:4:"main";s:5:"Clear";s:11:"description";s:11:"cielo claro";s:4:"icon";s:3:"01d";}}s:4:"base";s:8:"stations";s:4:"main";a:8:{s:4:"temp";d:9.98;s:10:"feels_like";d:8.9;s:8:"temp_min";d:9.98;s:8:"temp_max";d:9.98;s:8:"pressure";i:1020;s:8:"humidity";i:58;s:9:"sea_level";i:1020;s:10:"grnd_level";i:884;}s:10:"visibility";i:10000;s:4:"wind";a:3:{s:5:"speed";d:2.35;s:3:"deg";i:266;s:4:"gust";d:3.18;}s:6:"clouds";a:1:{s:3:"all";i:7;}s:2:"dt";i:1781539857;s:3:"sys";a:3:{s:7:"country";s:2:"AR";s:7:"sunrise";i:1781525344;s:6:"sunset";i:1781558550;}s:8:"timezone";i:-10800;s:2:"id";i:7647007;s:4:"name";s:9:"Bariloche";s:3:"cod";i:200;}', 1781541708);
INSERT INTO public.cache VALUES ('laravel-cache-forecast_-41.1335_-71.3082', 'a:5:{s:3:"cod";s:3:"200";s:7:"message";i:0;s:3:"cnt";i:8;s:4:"list";a:8:{i:0;a:9:{s:2:"dt";i:1781546400;s:4:"main";a:9:{s:4:"temp";d:9.38;s:10:"feels_like";d:7.86;s:8:"temp_min";d:9.38;s:8:"temp_max";d:11.01;s:8:"pressure";i:1020;s:9:"sea_level";i:1020;s:10:"grnd_level";i:883;s:8:"humidity";i:62;s:7:"temp_kf";d:-1.63;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:800;s:4:"main";s:5:"Clear";s:11:"description";s:11:"cielo claro";s:4:"icon";s:3:"01d";}}s:6:"clouds";a:1:{s:3:"all";i:5;}s:4:"wind";a:3:{s:5:"speed";d:2.85;s:3:"deg";i:266;s:4:"gust";d:3.76;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"d";}s:6:"dt_txt";s:19:"2026-06-15 18:00:00";}i:1;a:9:{s:2:"dt";i:1781557200;s:4:"main";a:9:{s:4:"temp";d:7.6;s:10:"feels_like";d:5.72;s:8:"temp_min";d:7.12;s:8:"temp_max";d:7.6;s:8:"pressure";i:1021;s:9:"sea_level";i:1021;s:10:"grnd_level";i:883;s:8:"humidity";i:76;s:7:"temp_kf";d:0.48;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:800;s:4:"main";s:5:"Clear";s:11:"description";s:11:"cielo claro";s:4:"icon";s:3:"01d";}}s:6:"clouds";a:1:{s:3:"all";i:1;}s:4:"wind";a:3:{s:5:"speed";d:2.86;s:3:"deg";i:252;s:4:"gust";d:3.18;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"d";}s:6:"dt_txt";s:19:"2026-06-15 21:00:00";}i:2;a:9:{s:2:"dt";i:1781568000;s:4:"main";a:9:{s:4:"temp";d:5.13;s:10:"feels_like";d:2.8;s:8:"temp_min";d:5.13;s:8:"temp_max";d:5.13;s:8:"pressure";i:1022;s:9:"sea_level";i:1022;s:10:"grnd_level";i:883;s:8:"humidity";i:75;s:7:"temp_kf";i:0;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:800;s:4:"main";s:5:"Clear";s:11:"description";s:11:"cielo claro";s:4:"icon";s:3:"01n";}}s:6:"clouds";a:1:{s:3:"all";i:0;}s:4:"wind";a:3:{s:5:"speed";d:2.82;s:3:"deg";i:253;s:4:"gust";d:3.16;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"n";}s:6:"dt_txt";s:19:"2026-06-16 00:00:00";}i:3;a:9:{s:2:"dt";i:1781578800;s:4:"main";a:9:{s:4:"temp";d:4.84;s:10:"feels_like";d:2.4;s:8:"temp_min";d:4.84;s:8:"temp_max";d:4.84;s:8:"pressure";i:1022;s:9:"sea_level";i:1022;s:10:"grnd_level";i:884;s:8:"humidity";i:63;s:7:"temp_kf";i:0;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:800;s:4:"main";s:5:"Clear";s:11:"description";s:11:"cielo claro";s:4:"icon";s:3:"01n";}}s:6:"clouds";a:1:{s:3:"all";i:4;}s:4:"wind";a:3:{s:5:"speed";d:2.88;s:3:"deg";i:257;s:4:"gust";d:2.98;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"n";}s:6:"dt_txt";s:19:"2026-06-16 03:00:00";}i:4;a:9:{s:2:"dt";i:1781589600;s:4:"main";a:9:{s:4:"temp";d:4.89;s:10:"feels_like";d:2.46;s:8:"temp_min";d:4.89;s:8:"temp_max";d:4.89;s:8:"pressure";i:1021;s:9:"sea_level";i:1021;s:10:"grnd_level";i:883;s:8:"humidity";i:54;s:7:"temp_kf";i:0;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:801;s:4:"main";s:6:"Clouds";s:11:"description";s:13:"algo de nubes";s:4:"icon";s:3:"02n";}}s:6:"clouds";a:1:{s:3:"all";i:19;}s:4:"wind";a:3:{s:5:"speed";d:2.88;s:3:"deg";i:251;s:4:"gust";d:3.05;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"n";}s:6:"dt_txt";s:19:"2026-06-16 06:00:00";}i:5;a:9:{s:2:"dt";i:1781600400;s:4:"main";a:9:{s:4:"temp";d:4.92;s:10:"feels_like";d:2.58;s:8:"temp_min";d:4.92;s:8:"temp_max";d:4.92;s:8:"pressure";i:1020;s:9:"sea_level";i:1020;s:10:"grnd_level";i:882;s:8:"humidity";i:49;s:7:"temp_kf";i:0;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:803;s:4:"main";s:6:"Clouds";s:11:"description";s:10:"muy nuboso";s:4:"icon";s:3:"04n";}}s:6:"clouds";a:1:{s:3:"all";i:53;}s:4:"wind";a:3:{s:5:"speed";d:2.77;s:3:"deg";i:243;s:4:"gust";d:2.77;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"n";}s:6:"dt_txt";s:19:"2026-06-16 09:00:00";}i:6;a:9:{s:2:"dt";i:1781611200;s:4:"main";a:9:{s:4:"temp";d:4.64;s:10:"feels_like";d:2.58;s:8:"temp_min";d:4.64;s:8:"temp_max";d:4.64;s:8:"pressure";i:1021;s:9:"sea_level";i:1021;s:10:"grnd_level";i:882;s:8:"humidity";i:45;s:7:"temp_kf";i:0;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:802;s:4:"main";s:6:"Clouds";s:11:"description";s:15:"nubes dispersas";s:4:"icon";s:3:"03n";}}s:6:"clouds";a:1:{s:3:"all";i:42;}s:4:"wind";a:3:{s:5:"speed";d:2.38;s:3:"deg";i:244;s:4:"gust";d:2.53;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"n";}s:6:"dt_txt";s:19:"2026-06-16 12:00:00";}i:7;a:9:{s:2:"dt";i:1781622000;s:4:"main";a:9:{s:4:"temp";d:10.58;s:10:"feels_like";d:8.79;s:8:"temp_min";d:10.58;s:8:"temp_max";d:10.58;s:8:"pressure";i:1018;s:9:"sea_level";i:1018;s:10:"grnd_level";i:883;s:8:"humidity";i:42;s:7:"temp_kf";i:0;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:801;s:4:"main";s:6:"Clouds";s:11:"description";s:13:"algo de nubes";s:4:"icon";s:3:"02d";}}s:6:"clouds";a:1:{s:3:"all";i:21;}s:4:"wind";a:3:{s:5:"speed";d:1.67;s:3:"deg";i:268;s:4:"gust";d:2.35;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"d";}s:6:"dt_txt";s:19:"2026-06-16 15:00:00";}}s:4:"city";a:8:{s:2:"id";i:7647007;s:4:"name";s:9:"Bariloche";s:5:"coord";a:2:{s:3:"lat";d:-41.1335;s:3:"lon";d:-71.3082;}s:7:"country";s:2:"AR";s:10:"population";i:15000;s:8:"timezone";i:-10800;s:7:"sunrise";i:1781525343;s:6:"sunset";i:1781558549;}}', 1781541708);
INSERT INTO public.cache VALUES ('laravel-cache-weather_-31.6333_-60.7', 'a:13:{s:5:"coord";a:2:{s:3:"lon";d:-60.7;s:3:"lat";d:-31.6333;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:804;s:4:"main";s:6:"Clouds";s:11:"description";s:5:"nubes";s:4:"icon";s:3:"04n";}}s:4:"base";s:8:"stations";s:4:"main";a:8:{s:4:"temp";d:7.86;s:10:"feels_like";d:6.9;s:8:"temp_min";d:7.17;s:8:"temp_max";d:8.33;s:8:"pressure";i:1022;s:8:"humidity";i:89;s:9:"sea_level";i:1022;s:10:"grnd_level";i:1020;}s:10:"visibility";i:10000;s:4:"wind";a:3:{s:5:"speed";d:1.79;s:3:"deg";i:342;s:4:"gust";d:3.58;}s:6:"clouds";a:1:{s:3:"all";i:100;}s:2:"dt";i:1781580470;s:3:"sys";a:5:{s:4:"type";i:2;s:2:"id";i:2008823;s:7:"country";s:2:"AR";s:7:"sunrise";i:1781607650;s:6:"sunset";i:1781643974;}s:8:"timezone";i:-10800;s:2:"id";i:3836277;s:4:"name";s:8:"Santa Fe";s:3:"cod";i:200;}', 1781582426);
INSERT INTO public.cache VALUES ('laravel-cache-forecast_-31.6333_-60.7', 'a:5:{s:3:"cod";s:3:"200";s:7:"message";i:0;s:3:"cnt";i:8;s:4:"list";a:8:{i:0;a:9:{s:2:"dt";i:1781589600;s:4:"main";a:9:{s:4:"temp";d:7.7;s:10:"feels_like";d:5.74;s:8:"temp_min";d:7.39;s:8:"temp_max";d:7.7;s:8:"pressure";i:1022;s:9:"sea_level";i:1022;s:10:"grnd_level";i:1019;s:8:"humidity";i:86;s:7:"temp_kf";d:0.31;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:804;s:4:"main";s:6:"Clouds";s:11:"description";s:5:"nubes";s:4:"icon";s:3:"04n";}}s:6:"clouds";a:1:{s:3:"all";i:98;}s:4:"wind";a:3:{s:5:"speed";d:3.01;s:3:"deg";i:339;s:4:"gust";d:6.67;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"n";}s:6:"dt_txt";s:19:"2026-06-16 06:00:00";}i:1;a:9:{s:2:"dt";i:1781600400;s:4:"main";a:9:{s:4:"temp";d:7.39;s:10:"feels_like";d:5.97;s:8:"temp_min";d:7.15;s:8:"temp_max";d:7.39;s:8:"pressure";i:1021;s:9:"sea_level";i:1021;s:10:"grnd_level";i:1018;s:8:"humidity";i:86;s:7:"temp_kf";d:0.24;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:803;s:4:"main";s:6:"Clouds";s:11:"description";s:10:"muy nuboso";s:4:"icon";s:3:"04n";}}s:6:"clouds";a:1:{s:3:"all";i:82;}s:4:"wind";a:3:{s:5:"speed";d:2.2;s:3:"deg";i:359;s:4:"gust";d:2.7;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"n";}s:6:"dt_txt";s:19:"2026-06-16 09:00:00";}i:2;a:9:{s:2:"dt";i:1781611200;s:4:"main";a:9:{s:4:"temp";d:8.16;s:10:"feels_like";d:6.92;s:8:"temp_min";d:8.16;s:8:"temp_max";d:8.16;s:8:"pressure";i:1021;s:9:"sea_level";i:1021;s:10:"grnd_level";i:1019;s:8:"humidity";i:87;s:7:"temp_kf";i:0;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:803;s:4:"main";s:6:"Clouds";s:11:"description";s:10:"muy nuboso";s:4:"icon";s:3:"04d";}}s:6:"clouds";a:1:{s:3:"all";i:76;}s:4:"wind";a:3:{s:5:"speed";d:2.15;s:3:"deg";i:0;s:4:"gust";d:4.96;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"d";}s:6:"dt_txt";s:19:"2026-06-16 12:00:00";}i:3;a:9:{s:2:"dt";i:1781622000;s:4:"main";a:9:{s:4:"temp";d:14.89;s:10:"feels_like";d:14.13;s:8:"temp_min";d:14.89;s:8:"temp_max";d:14.89;s:8:"pressure";i:1021;s:9:"sea_level";i:1021;s:10:"grnd_level";i:1019;s:8:"humidity";i:65;s:7:"temp_kf";i:0;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:803;s:4:"main";s:6:"Clouds";s:11:"description";s:10:"muy nuboso";s:4:"icon";s:3:"04d";}}s:6:"clouds";a:1:{s:3:"all";i:77;}s:4:"wind";a:3:{s:5:"speed";d:3.5;s:3:"deg";i:334;s:4:"gust";d:5.39;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"d";}s:6:"dt_txt";s:19:"2026-06-16 15:00:00";}i:4;a:9:{s:2:"dt";i:1781632800;s:4:"main";a:9:{s:4:"temp";d:17.97;s:10:"feels_like";d:17.28;s:8:"temp_min";d:17.97;s:8:"temp_max";d:17.97;s:8:"pressure";i:1019;s:9:"sea_level";i:1019;s:10:"grnd_level";i:1017;s:8:"humidity";i:56;s:7:"temp_kf";i:0;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:803;s:4:"main";s:6:"Clouds";s:11:"description";s:10:"muy nuboso";s:4:"icon";s:3:"04d";}}s:6:"clouds";a:1:{s:3:"all";i:72;}s:4:"wind";a:3:{s:5:"speed";d:3.46;s:3:"deg";i:331;s:4:"gust";d:4.86;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"d";}s:6:"dt_txt";s:19:"2026-06-16 18:00:00";}i:5;a:9:{s:2:"dt";i:1781643600;s:4:"main";a:9:{s:4:"temp";d:14.06;s:10:"feels_like";d:13.51;s:8:"temp_min";d:14.06;s:8:"temp_max";d:14.06;s:8:"pressure";i:1019;s:9:"sea_level";i:1019;s:10:"grnd_level";i:1016;s:8:"humidity";i:76;s:7:"temp_kf";i:0;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:804;s:4:"main";s:6:"Clouds";s:11:"description";s:5:"nubes";s:4:"icon";s:3:"04d";}}s:6:"clouds";a:1:{s:3:"all";i:92;}s:4:"wind";a:3:{s:5:"speed";d:2.37;s:3:"deg";i:359;s:4:"gust";d:2.39;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"d";}s:6:"dt_txt";s:19:"2026-06-16 21:00:00";}i:6;a:9:{s:2:"dt";i:1781654400;s:4:"main";a:9:{s:4:"temp";d:11.84;s:10:"feels_like";d:11.27;s:8:"temp_min";d:11.84;s:8:"temp_max";d:11.84;s:8:"pressure";i:1020;s:9:"sea_level";i:1020;s:10:"grnd_level";i:1018;s:8:"humidity";i:84;s:7:"temp_kf";i:0;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:804;s:4:"main";s:6:"Clouds";s:11:"description";s:5:"nubes";s:4:"icon";s:3:"04n";}}s:6:"clouds";a:1:{s:3:"all";i:96;}s:4:"wind";a:3:{s:5:"speed";d:1.9;s:3:"deg";i:357;s:4:"gust";d:1.98;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"n";}s:6:"dt_txt";s:19:"2026-06-17 00:00:00";}i:7;a:9:{s:2:"dt";i:1781665200;s:4:"main";a:9:{s:4:"temp";i:11;s:10:"feels_like";d:10.45;s:8:"temp_min";i:11;s:8:"temp_max";i:11;s:8:"pressure";i:1021;s:9:"sea_level";i:1021;s:10:"grnd_level";i:1019;s:8:"humidity";i:88;s:7:"temp_kf";i:0;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:804;s:4:"main";s:6:"Clouds";s:11:"description";s:5:"nubes";s:4:"icon";s:3:"04n";}}s:6:"clouds";a:1:{s:3:"all";i:100;}s:4:"wind";a:3:{s:5:"speed";d:1.76;s:3:"deg";i:357;s:4:"gust";d:1.77;}s:10:"visibility";i:10000;s:3:"pop";i:0;s:3:"sys";a:1:{s:3:"pod";s:1:"n";}s:6:"dt_txt";s:19:"2026-06-17 03:00:00";}}s:4:"city";a:8:{s:2:"id";i:3836277;s:4:"name";s:8:"Santa Fe";s:5:"coord";a:2:{s:3:"lat";d:-31.6333;s:3:"lon";d:-60.7;}s:7:"country";s:2:"AR";s:10:"population";i:489505;s:8:"timezone";i:-10800;s:7:"sunrise";i:1781607650;s:6:"sunset";i:1781643974;}}', 1781582427);
INSERT INTO public.cache VALUES ('laravel-cache-weather_-41.1335_-71.3103', 'a:13:{s:5:"coord";a:2:{s:3:"lon";d:-71.3103;s:3:"lat";d:-41.1335;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:800;s:4:"main";s:5:"Clear";s:11:"description";s:11:"cielo claro";s:4:"icon";s:3:"01n";}}s:4:"base";s:8:"stations";s:4:"main";a:8:{s:4:"temp";d:4.58;s:10:"feels_like";d:2.18;s:8:"temp_min";d:4.58;s:8:"temp_max";d:4.58;s:8:"pressure";i:1022;s:8:"humidity";i:63;s:9:"sea_level";i:1022;s:10:"grnd_level";i:883;}s:10:"visibility";i:10000;s:4:"wind";a:3:{s:5:"speed";d:2.77;s:3:"deg";i:253;s:4:"gust";d:2.89;}s:6:"clouds";a:1:{s:3:"all";i:1;}s:2:"dt";i:1781582763;s:3:"sys";a:3:{s:7:"country";s:2:"AR";s:7:"sunrise";i:1781611766;s:6:"sunset";i:1781644952;}s:8:"timezone";i:-10800;s:2:"id";i:7647007;s:4:"name";s:9:"Bariloche";s:3:"cod";i:200;}', 1781584637);
INSERT INTO public.cache VALUES ('laravel-cache-weather_-32.8908_-68.8458', 'a:13:{s:5:"coord";a:2:{s:3:"lon";d:-68.8458;s:3:"lat";d:-32.8908;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:804;s:4:"main";s:6:"Clouds";s:11:"description";s:5:"nubes";s:4:"icon";s:3:"04n";}}s:4:"base";s:8:"stations";s:4:"main";a:8:{s:4:"temp";d:10.12;s:10:"feels_like";d:8.47;s:8:"temp_min";d:10.12;s:8:"temp_max";d:10.12;s:8:"pressure";i:1019;s:8:"humidity";i:49;s:9:"sea_level";i:1019;s:10:"grnd_level";i:907;}s:10:"visibility";i:10000;s:4:"wind";a:3:{s:5:"speed";d:0.35;s:3:"deg";i:10;s:4:"gust";d:1.24;}s:6:"clouds";a:1:{s:3:"all";i:100;}s:2:"dt";i:1781582764;s:3:"sys";a:3:{s:7:"country";s:2:"AR";s:7:"sunrise";i:1781609790;s:6:"sunset";i:1781645745;}s:8:"timezone";i:-10800;s:2:"id";i:3844421;s:4:"name";s:7:"Mendoza";s:3:"cod";i:200;}', 1781584638);
INSERT INTO public.cache VALUES ('laravel-cache-weather_-24.7821_-65.4117', 'a:13:{s:5:"coord";a:2:{s:3:"lon";d:-65.4117;s:3:"lat";d:-24.7821;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:804;s:4:"main";s:6:"Clouds";s:11:"description";s:5:"nubes";s:4:"icon";s:3:"04n";}}s:4:"base";s:8:"stations";s:4:"main";a:8:{s:4:"temp";i:7;s:10:"feels_like";i:7;s:8:"temp_min";i:7;s:8:"temp_max";i:7;s:8:"pressure";i:1023;s:8:"humidity";i:93;s:9:"sea_level";i:1023;s:10:"grnd_level";i:876;}s:10:"visibility";i:10000;s:4:"wind";a:3:{s:5:"speed";d:0.96;s:3:"deg";i:15;s:4:"gust";d:0.69;}s:6:"clouds";a:1:{s:3:"all";i:100;}s:2:"dt";i:1781582837;s:3:"sys";a:5:{s:4:"type";i:2;s:2:"id";i:2038258;s:7:"country";s:2:"AR";s:7:"sunrise";i:1781607859;s:6:"sunset";i:1781646027;}s:8:"timezone";i:-10800;s:2:"id";i:3838233;s:4:"name";s:5:"Salta";s:3:"cod";i:200;}', 1781584639);
INSERT INTO public.cache VALUES ('laravel-cache-weather_-34.6037_-58.3816', 'a:13:{s:5:"coord";a:2:{s:3:"lon";d:-58.3816;s:3:"lat";d:-34.6037;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:800;s:4:"main";s:5:"Clear";s:11:"description";s:11:"cielo claro";s:4:"icon";s:3:"01n";}}s:4:"base";s:8:"stations";s:4:"main";a:8:{s:4:"temp";d:8.99;s:10:"feels_like";d:6.23;s:8:"temp_min";d:7.72;s:8:"temp_max";d:9.97;s:8:"pressure";i:1019;s:8:"humidity";i:81;s:9:"sea_level";i:1019;s:10:"grnd_level";i:1018;}s:10:"visibility";i:10000;s:4:"wind";a:3:{s:5:"speed";d:5.26;s:3:"deg";i:303;s:4:"gust";d:11.53;}s:6:"clouds";a:1:{s:3:"all";i:0;}s:2:"dt";i:1781582710;s:3:"sys";a:5:{s:4:"type";i:2;s:2:"id";i:2020613;s:7:"country";s:2:"AR";s:7:"sunrise";i:1781607539;s:6:"sunset";i:1781642972;}s:8:"timezone";i:-10800;s:2:"id";i:6693229;s:4:"name";s:11:"San Nicolas";s:3:"cod";i:200;}', 1781584640);
INSERT INTO public.cache VALUES ('laravel-cache-weather_-25.5991_-54.5736', 'a:13:{s:5:"coord";a:2:{s:3:"lon";d:-54.5736;s:3:"lat";d:-25.5991;}s:7:"weather";a:1:{i:0;a:4:{s:2:"id";i:803;s:4:"main";s:6:"Clouds";s:11:"description";s:10:"muy nuboso";s:4:"icon";s:3:"04n";}}s:4:"base";s:8:"stations";s:4:"main";a:8:{s:4:"temp";d:8.25;s:10:"feels_like";d:7.77;s:8:"temp_min";d:8.25;s:8:"temp_max";d:8.25;s:8:"pressure";i:1021;s:8:"humidity";i:90;s:9:"sea_level";i:1021;s:10:"grnd_level";i:995;}s:10:"visibility";i:10000;s:4:"wind";a:3:{s:5:"speed";d:1.4;s:3:"deg";i:168;s:4:"gust";d:2.55;}s:6:"clouds";a:1:{s:3:"all";i:65;}s:2:"dt";i:1781582766;s:3:"sys";a:3:{s:7:"country";s:2:"AR";s:7:"sunrise";i:1781605361;s:6:"sunset";i:1781643322;}s:8:"timezone";i:-10800;s:2:"id";i:3429777;s:4:"name";s:14:"Puerto Iguazú";s:3:"cod";i:200;}', 1781584641);


--
-- TOC entry 6116 (class 0 OID 28611)
-- Dependencies: 226
-- Data for Name: cache_locks; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 6117 (class 0 OID 28619)
-- Dependencies: 227
-- Data for Name: configuraciones; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 6119 (class 0 OID 28628)
-- Dependencies: 229
-- Data for Name: destinos; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.destinos VALUES (72, 1, 'Mar del Plata', 'La ciudad más popular de verano de Argentina con playas y casino', '$', 'playa', '0101000020E610000027A089B0E1F94CC0F163CC5D4B0043C0', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=400', true, '2026-06-12 11:11:19', '2026-06-12 11:11:19');
INSERT INTO public.destinos VALUES (73, 1, 'Sierra de la Ventana', 'Serranías con cascadas, senderismo y paisajes únicos', '$', 'naturaleza', '0101000020E6100000787AA52C43E44EC0454772F90F1143C0', 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=400', true, '2026-06-12 11:11:19', '2026-06-12 11:11:19');
INSERT INTO public.destinos VALUES (74, 5, 'Villa Carlos Paz', 'Ciudad turística a orillas del lago San Roque', '$', 'lago', '0101000020E6100000006F8104C51F50C0CD3B4ED1916C3FC0', 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=400', true, '2026-06-12 11:11:19', '2026-06-12 11:11:19');
INSERT INTO public.destinos VALUES (75, 5, 'La Cumbrecita', 'Pintoresco pueblo de montaña con arquitectura alpina', '$', 'pueblo', '0101000020E6100000A323B9FC873850C0575BB1BFECEE3FC0', 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400', true, '2026-06-12 11:11:19', '2026-06-12 11:11:19');
INSERT INTO public.destinos VALUES (76, 13, 'Cataratas del Iguazú', 'Las cataratas más grandes del mundo, Patrimonio UNESCO', '$$', 'naturaleza', '0101000020E6100000D42B6519E2384BC0A7E8482EFFB139C0', 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400', true, '2026-06-12 11:11:19', '2026-06-12 11:11:19');
INSERT INTO public.destinos VALUES (77, 9, 'Quebrada de Humahuaca', 'Patrimonio de la Humanidad, coloridas montañas y pueblos', '$', 'cultura', '0101000020E610000066666666665650C033333333333337C0', 'https://images.unsplash.com/photo-1601039641847-7857b994d704?w=400', true, '2026-06-12 11:11:19', '2026-06-12 11:11:19');
INSERT INTO public.destinos VALUES (78, 9, 'Purmamarca', 'Famoso por el Cerro de los Siete Colores', '$', 'cultura', '0101000020E610000000000000006050C024287E8CB9BB37C0', 'https://images.unsplash.com/photo-1548013146-72479768bada?w=400', true, '2026-06-12 11:11:19', '2026-06-12 11:11:19');
INSERT INTO public.destinos VALUES (79, 19, 'Glaciar Perito Moreno', 'Uno de los glaciares más espectaculares del mundo', '$$', 'naturaleza', '0101000020E61000006FF085C9544552C0454772F90F4149C0', 'https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?w=400', true, '2026-06-12 11:11:19', '2026-06-12 11:11:19');
INSERT INTO public.destinos VALUES (80, 19, 'El Calafate', 'Ciudad turística puerta de entrada a la Patagonia', '$$', 'ciudad', '0101000020E6100000F775E09C111152C0DFE00B93A92A49C0', 'https://images.unsplash.com/photo-1589556264800-08ae9e129a8e?w=400', true, '2026-06-12 11:11:19', '2026-06-12 11:11:19');
INSERT INTO public.destinos VALUES (81, 12, 'Mendoza Capital', 'Ciudad del vino con bodegas y montañas nevadas', '$$', 'ciudad', '0101000020E61000003CBD5296213651C06EA301BC057240C0', 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=400', true, '2026-06-12 11:11:19', '2026-06-12 11:11:19');
INSERT INTO public.destinos VALUES (82, 12, 'Aconcagua', 'El pico más alto del hemisferio occidental', '$$$', 'montaña', '0101000020E6100000B1E1E995B28051C0A4DFBE0E9C5340C0', 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=400', true, '2026-06-12 11:11:19', '2026-06-12 11:11:19');
INSERT INTO public.destinos VALUES (83, 16, 'Salta Capital', 'La linda, ciudad colonial con arquitectura impresionante', '$', 'cultura', '0101000020E6100000D8F0F44A595A50C09C33A2B437C838C0', 'https://images.unsplash.com/photo-1601039641847-7857b994d704?w=400', true, '2026-06-12 11:11:19', '2026-06-12 11:11:19');
INSERT INTO public.destinos VALUES (84, 16, 'Cafayate', 'Valle de viñedos con paisajes desérticos increíbles', '$', 'naturaleza', '0101000020E6100000098A1F63EE7E50C0A9A44E4013113AC0', 'https://images.unsplash.com/photo-1548013146-72479768bada?w=400', true, '2026-06-12 11:11:19', '2026-06-12 11:11:19');
INSERT INTO public.destinos VALUES (85, 14, 'Bariloche', 'La Suiza argentina, lagos y montañas patagónicas', '$$', 'montaña', '0101000020E6100000B9FC87F4DBD351C00C022B87169144C0', 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400', true, '2026-06-12 11:11:19', '2026-06-12 11:11:19');
INSERT INTO public.destinos VALUES (86, 14, 'Villa La Angostura', 'Pintoresco pueblo lacustre rodeado de bosques', '$$', 'naturaleza', '0101000020E6100000A323B9FC87E851C0EEEBC039236244C0', 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=400', true, '2026-06-12 11:11:19', '2026-06-12 11:11:19');
INSERT INTO public.destinos VALUES (87, 8, 'Bañado La Estrella', 'Humedal único con fauna y flora autóctona', '$', 'naturaleza', '0101000020E6100000211FF46C56954EC000000000008038C0', 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=400', true, '2026-06-12 11:11:19', '2026-06-12 11:11:19');
INSERT INTO public.destinos VALUES (88, 24, 'Buenos Aires Capital', 'La capital federal, metrópolis vibrante con cultura y gastronomía', '$$', 'ciudad', '0101000020E6100000A913D044D8304DC0304CA60A464D41C0', 'https://images.unsplash.com/photo-1589556264800-08ae9e129a8e?w=400', true, '2026-06-12 11:11:19', '2026-06-12 11:11:19');
INSERT INTO public.destinos VALUES (89, 14, 'San Martín de los Andes', 'Una encantadora ciudad de montaña a orillas del Lago Lácar. Es el punto de inicio de la mundialmente famosa Ruta de los Siete Lagos. Ofrece esquí en invierno (Cerro Chapelco) y trekking, kayak y pesca con mosca en verano.', 'Alto', 'Aventura', '0101000020E6100000C364AA6054D651C0DDB5847CD01344C0', 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?w=500', true, '2026-06-15 00:24:23', '2026-06-15 00:24:23');
INSERT INTO public.destinos VALUES (90, 15, 'San Carlos de Bariloche', 'El destino turístico más importante de la Patagonia. Famosa por sus chocolates artesanales, cervecerías locales y el imponente Cerro Catedral. Ideal para visitar todo el año.', 'Alto', 'Aventura', '0101000020E610000024287E8CB9D351C00C022B87169144C0', 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=500', true, '2026-06-15 00:24:24', '2026-06-15 00:24:24');


--
-- TOC entry 6121 (class 0 OID 28641)
-- Dependencies: 231
-- Data for Name: destinos_visitados; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.destinos_visitados VALUES (2, 2, 89, '2026-01-15', '2026-06-15 00:24:24', '2026-06-15 00:24:24');


--
-- TOC entry 6157 (class 0 OID 29005)
-- Dependencies: 267
-- Data for Name: evento_favoritos; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 6159 (class 0 OID 29027)
-- Dependencies: 269
-- Data for Name: evento_visitados; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 6123 (class 0 OID 28648)
-- Dependencies: 233
-- Data for Name: eventos; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.eventos VALUES (4, 14, 89, 'Apertura de Temporada Cerro Chapelco', 'Deportivo', '2026-06-20', '2026-06-21', NULL, 'Alto', 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=500', true, '2026-06-15 00:24:24', '2026-06-15 00:24:24', NULL, NULL);
INSERT INTO public.eventos VALUES (5, 15, 90, 'Fiesta Nacional del Chocolate', 'Gastronómico', '2026-04-02', '2026-04-05', NULL, 'Bajo', 'https://images.unsplash.com/photo-1511381939415-e44015466834?w=500', true, '2026-06-15 00:24:24', '2026-06-15 00:24:24', NULL, NULL);
INSERT INTO public.eventos VALUES (6, 16, 84, 'Serenata a Cafayate', 'Musical', '2026-02-19', '2026-02-22', NULL, 'Medio', 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?w=500', true, '2026-06-15 00:24:24', '2026-06-15 00:24:24', NULL, NULL);


--
-- TOC entry 6125 (class 0 OID 28661)
-- Dependencies: 235
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 6127 (class 0 OID 28675)
-- Dependencies: 237
-- Data for Name: favoritos; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.favoritos VALUES (3, 2, 89, NULL, '2026-06-15 00:24:24', '2026-06-15 00:24:24');
INSERT INTO public.favoritos VALUES (4, 2, NULL, 5, '2026-06-15 00:24:24', '2026-06-15 00:24:24');


--
-- TOC entry 6129 (class 0 OID 28681)
-- Dependencies: 239
-- Data for Name: gastronomia; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.gastronomia VALUES (3, 15, 'Cordero Patagónico al Asador', 'Exquisitez patagónica cocinada a fuego lento durante horas, logrando una carne extremadamente tierna y sabrosa.', 'Plato principal', 'gastronomia/dBtNsPZygoEauHqSQy6eUvJ2qkr8LKwAFczIEZMp.webp', '2026-06-15 00:24:24', '2026-06-15 14:36:11');
INSERT INTO public.gastronomia VALUES (4, 16, 'Empanadas Salteñas', 'Las empanadas más jugosas y famosas de Argentina. Rellenas de carne cortada a cuchillo, papa, huevo y cebolla de verdeo.', 'Entrada', 'gastronomia/E9HLjzEieGd595y2jVWt4RUcCRsvJFzXPl6NKjZn.jpg', '2026-06-15 00:24:24', '2026-06-15 14:37:03');
INSERT INTO public.gastronomia VALUES (5, 1, 'Asado Bonaerense', 'El asado es el plato más representativo de la provincia, preparado con cortes de res a las brasas. Se sirve con chimichurri y ensaladas frescas. Es el centro de toda reunión social y familiar en la región pampeana.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (6, 1, 'Milanesa a la Napolitana', 'Milanesa de carne rebozada cubierta con salsa de tomate, jamón y queso gratinado. Es un clásico de los bodegones y restaurantes porteños que se extendió por toda la provincia. Se sirve generalmente con papas fritas.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (7, 1, 'Empanadas de Carne', 'Empanadas rellenas con carne picada, cebolla, huevo duro y aceitunas, horneadas o fritas. Cada familia tiene su propia receta secreta transmitida de generación en generación. Son infaltables en las fiestas y reuniones.', 'Entrada', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (8, 1, 'Dulce de Leche', 'Producto emblemático argentino elaborado con leche y azúcar cocidos lentamente hasta obtener una crema dulce y espesa. Se usa en alfajores, tortas, medialunas y como acompañamiento de postres. Es orgullo nacional reconocido mundialmente.', 'Postre', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (9, 2, 'Locro Catamarqueño', 'Guiso espeso y contundente elaborado con maíz blanco, porotos, zapallo, carne de cerdo y chorizo colorado. Es el plato más tradicional de la provincia, especialmente consumido en invierno y en fechas patrias. Su preparación requiere varias horas de cocción lenta.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (10, 2, 'Empanadas de Humita', 'Empanadas rellenas con humita, una mezcla cremosa de choclo rallado, cebolla, pimiento y queso. Son una especialidad de la cocina andina catamarqueña con raíces prehispánicas. Se hornean hasta dorar y se consumen calientes.', 'Entrada', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (11, 2, 'Tamales', 'Preparación prehispánica de masa de maíz rellena con carne y condimentos, envuelta en chala de choclo y cocida al vapor. Es uno de los platos más antiguos de la región andina argentina. Se consumen especialmente en festividades tradicionales.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (12, 2, 'Arrope de Tuna', 'Dulce artesanal elaborado con el jugo de la tuna cocido hasta obtener una consistencia espesa y oscura. Es una tradición centenaria en los valles catamarqueños aprovechando el fruto del cactus nativo. Se usa como mermelada o acompañamiento de quesos.', 'Postre', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (13, 3, 'Mbeyú', 'Tortilla típica de la cultura guaraní elaborada con almidón de mandioca, queso y grasa. Se cocina en sartén o sobre brasas hasta quedar crocante por fuera y suave por dentro. Es un desayuno o merienda muy popular en toda la región chaqueña.', 'Entrada', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (14, 3, 'Locro Chaqueño', 'Versión regional del locro con maíz, porotos y carne de carpincho o yacaré, ingredientes característicos del Chaco. Es un plato contundente que refleja la fusión entre la cocina criolla y la tradición indígena local. Se consume principalmente en invierno.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (15, 3, 'Sopa Paraguaya', 'A pesar de su nombre, es en realidad una especie de torta salada de maíz con queso y cebolla. Es un plato de herencia guaraní muy popular en el noreste argentino. Se sirve como acompañamiento o plato principal.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (16, 3, 'Tereré', 'Bebida refrescante elaborada con yerba mate y agua fría o jugo de frutas cítricas. Es la versión fría del mate tradicional, muy popular en las zonas de clima cálido del Chaco. Se bebe en ronda como signo de amistad y comunidad.', 'Bebida', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (17, 4, 'Cordero Patagónico al Asador', 'Cordero entero cocinado lentamente al asador criollo durante varias horas sobre brasas de leña. Es el plato más emblemático de la Patagonia, con una carne tierna y sabrosa de ovinos criados en libertad. Se acompaña con chimichurri y ensaladas.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (18, 4, 'Torta Galesa', 'Postre tradicional traído por los colonos galeses que se asentaron en el Valle del Chubut en 1865. Es un budín denso con frutos secos, especias y a veces regado con whisky. Se sirve en las casas de té de Gaiman y Trelew como símbolo de la herencia galesa.', 'Postre', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (19, 4, 'Centolla Fueguina', 'Cangrejo gigante de las aguas frías del Atlántico sur, cocido al vapor y servido con limón y manteca. Su carne blanca y sabrosa es considerada un manjar de la gastronomía patagónica. Se consigue fresco en los puertos de la región.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (20, 4, 'Té Galés con Scones', 'Tradición heredada de los colonos galeses que consiste en un té negro servido con scones, mermeladas artesanales y crema. Se sirve en las casas de té del Valle del Chubut manteniendo la costumbre de más de 150 años. Es una experiencia cultural única en Argentina.', 'Bebida', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (21, 5, 'Asado con Cuero', 'Técnica tradicional serrana donde la carne se asa con el cuero del animal, lo que le da una jugosidad y sabor únicos. Es especialmente popular en las sierras cordobesas durante festividades y reuniones familiares. El cuero actúa como sello que retiene todos los jugos.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (22, 5, 'Chancho al Horno', 'Cerdo entero o en piezas marinado con hierbas serranas y cocinado lentamente al horno de barro. Es una tradición de los pueblos serranos de Córdoba, especialmente en épocas de frío. Se acompaña con batatas asadas y ensaladas.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (23, 5, 'Alfajor Cordobés', 'Alfajor triple de maicena relleno con abundante dulce de leche y bañado en chocolate o azúcar impalpable. Córdoba es considerada la capital del alfajor artesanal argentino. Cada confitería tiene su receta única transmitida por generaciones.', 'Postre', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (24, 5, 'Empanadas Cordobesas', 'Empanadas con un repulgue característico en forma de trenza, rellenas de carne con papa, huevo y pasas de uva. Son reconocidas en todo el país por su toque dulzón que las diferencia del resto. Se hornean y se comen con la mano según la tradición.', 'Entrada', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (25, 6, 'Chipá', 'Pan de almidón de mandioca y queso de origen guaraní, cocido en horno hasta quedar dorado y crocante. Es el snack más popular del noreste argentino, infaltable en desayunos y meriendas. Su aroma al hornearse es característico de los mercados y terminales correntinas.', 'Snack', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (26, 6, 'Reviro', 'Preparación rústica de harina de mandioca tostada en grasa con cebolla y condimentos. Es el desayuno tradicional de los pueblos rurales correntinos y misioneros. Se consume con mate cocido y refleja la herencia guaraní de la región.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (27, 6, 'Surubí al Horno', 'Surubí, el gran bagre del río Paraná, preparado al horno con limón, ajo y hierbas locales. Es el pescado de río más apreciado de Corrientes, conocido por su carne blanca y sin espinas. Se sirve en los restaurantes a orillas del Paraná.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (28, 6, 'Mate Correntino', 'El mate en Corrientes tiene una cultura propia con rituales específicos y mezclas de hierbas locales como el cedrón y la menta. Es una bebida social que acompaña todas las actividades del día. La región es una de las principales productoras de yerba mate del país.', 'Infusión', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (29, 7, 'Dorado a la Parrilla', 'El dorado, conocido como el tigre del río Uruguay, asado a la parrilla con limón y hierbas. Es el rey de la pesca deportiva y gastronómica entrerriana. Su carne firme y sabrosa lo convierte en el plato más buscado por los turistas.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (30, 7, 'Empanadas Entrerrianas', 'Empanadas jugosas rellenas con carne vacuna, huevo y verduras, con un repulgue característico de la región. Cada localidad entrerriana tiene su variante propia con ingredientes locales. Son infaltables en las festividades del carnaval de Gualeguaychú.', 'Entrada', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (31, 7, 'Arroz con Leche Criollo', 'Postre tradicional elaborado con arroz, leche entera, azúcar y canela, cocinado lentamente hasta obtener una consistencia cremosa. Es un clásico de la cocina casera entrerriana heredado de la tradición española. Se sirve frío con una pizca de canela encima.', 'Postre', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (32, 7, 'Sopa de Mondongo', 'Guiso contundente elaborado con mondongo, garbanzos, chorizo y verduras de estación. Es un plato de invierno muy arraigado en la cultura rural entrerriana. Su preparación lenta en olla de hierro le da un sabor profundo e inconfundible.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (33, 8, 'Pirá Pytá', 'Guiso de pescado de río con tomate, pimiento, cebolla y condimentos típicos de la cocina formoseña. Pirá Pytá significa pez colorado en lengua qom. Es uno de los platos más representativos de la gastronomía del Pilcomayo.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (34, 8, 'Mbejú Formoseño', 'Torta de almidón de mandioca y queso típica de la cultura guaraní y qom de Formosa. Se cocina en sartén de hierro y queda crocante por fuera con un interior suave y elástico. Es el desayuno más tradicional de la provincia.', 'Entrada', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (35, 8, 'Locro de Maíz Blanco', 'Locro elaborado con maíz blanco pisado, porotos, zapallo y carne de cerdo o vacuna. Es el plato más consumido en los meses de invierno en toda la provincia. Su preparación es un ritual familiar que convoca a toda la comunidad.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (36, 8, 'Aloja de Algarroba', 'Bebida fermentada ancestral elaborada con vainas de algarroba, fruto nativo del Chaco. Es una bebida ceremonial de los pueblos originarios qom y wichí de Formosa. Tiene un sabor dulzón y levemente ácido con bajo contenido alcohólico.', 'Bebida', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (37, 9, 'Humita en Chala', 'Preparación andina de choclo rallado mezclado con queso, cebolla y pimiento, envuelto en hojas de choclo y cocido al vapor. Es uno de los platos más antiguos de la cocina andina con origen prehispánico. Se consume especialmente durante la temporada de choclo fresco.', 'Entrada', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (38, 9, 'Locro Jujeño', 'Versión andina del locro con maíz morado, papas andinas, carne de llama y charqui. Refleja la rica herencia culinaria de los pueblos originarios de la Puna jujeña. Es el plato más convocante en las fiestas patrias y celebraciones andinas.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (39, 9, 'Tamales Jujeños', 'Tamales de masa de maíz rellenos con carne de cerdo y condimentos andinos, envueltos en chala y cocidos al vapor. Son una tradición gastronómica que data de tiempos preincaicos en la región. Se venden en los mercados artesanales de Humahuaca y Tilcara.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (40, 9, 'Api', 'Bebida caliente y espesa elaborada con maíz morado, canela, clavo de olor y azúcar. Es una infusión ancestral andina que se consume especialmente en las madrugadas frías de la Puna. Tiene un color morado intenso y un sabor dulce y especiado reconfortante.', 'Bebida', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (41, 10, 'Asado Pampeano', 'Asado criollo con cortes típicos de la región ganadera pampeana como el vacío, la tira de asado y el chorizo. La carne de la Pampa es reconocida por su calidad excepcional gracias a los campos naturales donde pasta el ganado. Es el plato central de toda reunión social.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (42, 10, 'Chivito al Asador', 'Cabrito entero cocinado lentamente al asador criollo sobre brasas de caldén, árbol nativo pampeano. Es una especialidad ganadera de la región que se prepara en ocasiones especiales. Su carne tierna y de sabor delicado es muy apreciada por los conocedores.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (43, 10, 'Pastel de Papa', 'Pastel elaborado con puré de papa, carne picada con cebolla y condimentos, gratinado en horno. Es un plato de cocina casera muy arraigado en los hogares pampeanos durante el invierno. Su simplicidad y contundencia lo hacen ideal para los trabajadores rurales.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (44, 10, 'Dulce de Calabaza', 'Conserva dulce elaborada con calabaza, azúcar y cáscara de limón, cocida lentamente hasta obtener trozos translúcidos. Es una tradición artesanal de las familias rurales pampeanas para aprovechar la cosecha. Se consume con queso fresco o en tostadas.', 'Postre', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (45, 11, 'Empanadas Riojanas', 'Empanadas fritas con relleno de carne vacuna, cebolla, comino y ají molido, con un toque picante característico. Son reconocidas en todo el país por su sabor intenso y su masa fina y crocante. Se venden en puestos callejeros de toda la provincia.', 'Entrada', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (46, 11, 'Guiso de Trigo', 'Guiso elaborado con trigo pelado, porotos, carne y verduras de estación. Es un plato de origen humilde muy arraigado en la cocina rural riojana. Su preparación en olla de hierro sobre fuego lento le otorga un sabor profundo y reconfortante.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (47, 11, 'Arrope de Chañar', 'Dulce ancestral elaborado con el fruto del chañar, árbol nativo del monte riojano, cocido hasta obtener una miel oscura y espesa. Es un remedio natural y golosina tradicional de los pueblos originarios de la región. Se usa como jarabe para la tos y como endulzante natural.', 'Postre', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (48, 11, 'Vino Torrontés Riojano', 'Vino blanco aromático elaborado con la uva Torrontés Riojano, cepa emblemática de la provincia. Tiene un aroma intenso a flores y frutas tropicales con un sabor fresco y seco. La Rioja es la cuna de esta variedad única en el mundo.', 'Bebida', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (49, 12, 'Asado con Vino Malbec', 'Tradición mendocina de acompañar el asado criollo con el emblemático vino Malbec de la región. La combinación entre la carne vacuna y los taninos del Malbec crea una experiencia gastronómica única. Es el maridaje más representativo de la cultura del vino mendocina.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (50, 12, 'Cazuela de Cordero', 'Guiso de cordero con papas, zanahorias, zapallo y hierbas de montaña cocinado lentamente. Es un plato de invierno muy popular en las zonas cordilleranas de Mendoza. El cordero criado en las laderas andinas tiene un sabor inconfundible.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (51, 12, 'Vendimia Empanadas', 'Empanadas con relleno de carne, huevo y pasas de uva, estas últimas como tributo a la industria vitivinícola mendocina. Se elaboran especialmente durante la Fiesta de la Vendimia en marzo. Representan la fusión entre la tradición criolla y la cultura del vino.', 'Entrada', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (52, 12, 'Dulce de Uva', 'Mermelada artesanal elaborada con uvas Malbec o Criolla cosechadas en los viñedos mendocinos. Tiene un color rojo intenso y un sabor profundo a fruta madura con notas vinosas. Se produce en las bodegas y queserías de la región como complemento del queso de cabra.', 'Postre', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (53, 13, 'Chipá Guazú', 'Torta salada de choclo fresco rallado con queso y huevos, horneada hasta quedar dorada. Es la versión grande del chipá tradicional guaraní, muy popular en toda la provincia. Se consume como plato principal o acompañamiento en las fiestas misioneras.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (54, 13, 'Pacú a la Parrilla', 'Pacú, el gran pez del río Paraná, preparado a la parrilla con limón y hierbas locales. Es el pescado más popular de Misiones por su carne blanca, grasa y muy sabrosa. Se sirve en los restaurantes a orillas del río como plato estrella de la gastronomía regional.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (55, 13, 'Yerba Mate Misionera', 'La yerba mate producida en Misiones es la más consumida en Argentina, con variedades con y sin palo. La provincia alberga los mayores yerbatales del país en su clima subtropical húmedo. La cultura del mate es parte esencial de la identidad misionera.', 'Infusión', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (56, 13, 'Mbejú de Misiones', 'Torta de almidón de mandioca con queso, típica de la gastronomía guaraní de Misiones. Se cocina en sartén de hierro y se consume recién hecha, caliente y crocante. Es el desayuno y merienda más tradicional en las zonas rurales de la provincia.', 'Snack', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (57, 14, 'Chivo Neuquino al Asador', 'Chivo de la raza Neuquina criado en la cordillera patagónica, cocinado al asador durante horas sobre brasas de leña. Es el plato más emblemático de la provincia, con una carne magra y sabrosa de animales que pastorean libremente. Se declara Patrimonio Cultural de Neuquén.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (58, 14, 'Trucha Patagónica', 'Trucha arcoíris criada en los ríos y lagos de la cordillera neuquina, preparada al horno o a la parrilla con hierbas y limón. Es el pescado de agua dulce más apreciado de la Patagonia argentina. Los ríos Aluminé y Limay son famosos mundialmente por la pesca de truchas.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (59, 14, 'Curanto', 'Preparación mapuche ancestral de carnes, mariscos y vegetales cocidos bajo tierra sobre piedras calientes. Es uno de los platos más originales y ceremoniales de la cultura mapuche neuquina. Su preparación es un evento comunitario que puede durar todo el día.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (60, 14, 'Piñón Mapuche', 'Fruto del pehuén o araucaria, árbol sagrado mapuche, cocido o tostado y consumido como alimento. Los piñones son la base de la dieta invernal mapuche desde tiempos inmemoriales. Tienen un sabor similar a la castaña y alto valor nutritivo.', 'Snack', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (61, 15, 'Cordero Patagónico Rionegrino', 'Cordero criado en la estepa rionegrina, de carne magra y sabor intenso por alimentarse de hierbas aromáticas silvestres. Se prepara al asador criollo o al horno de barro con hierbas locales. Es el orgullo gastronómico de la provincia y referente de la cocina patagónica.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (62, 15, 'Dulce de Manzana del Valle', 'Mermelada artesanal elaborada con las manzanas del Alto Valle del Río Negro, la mayor región frutícola de Argentina. Tiene una textura suave y un sabor natural intenso a manzana madura. Se produce en pequeñas fábricas familiares del Valle siguiendo recetas tradicionales.', 'Postre', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (63, 15, 'Sidra Patagónica', 'Bebida fermentada elaborada con manzanas del Alto Valle, producida artesanalmente siguiendo métodos tradicionales europeos. La región es el mayor productor de sidra artesanal de Argentina. Tiene un sabor fresco, levemente dulce y una burbuja fina muy agradable.', 'Bebida', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (64, 15, 'Truchas del Nahuel Huapi', 'Truchas capturadas o criadas en el lago Nahuel Huapi y ríos aledaños, preparadas ahumadas o al horno. El ahumado artesanal con maderas nativas le da un sabor y aroma únicos. Son un producto gourmet muy buscado por los turistas que visitan Bariloche.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (65, 16, 'Empanadas Salteñas', 'Las empanadas más famosas del país, con relleno de carne cortada a cuchillo, papa, huevo, cebolla y ají amarillo. Se hornean en horno de barro y se reconocen por su repulgue de 13 dobleces. Son Patrimonio Cultural Inmaterial de la provincia de Salta.', 'Entrada', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (66, 16, 'Locro Salteño', 'Versión norteña del locro con maíz blanco, porotos, carne de cerdo, chorizo colorado y mondongo. Es el plato más consumido en invierno y en las fiestas patrias del 25 de mayo. Su preparación familiar dura varias horas y convoca a toda la comunidad.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (67, 16, 'Tamales Salteños', 'Tamales de masa de maíz rellenos con carne de cerdo y vacuna, envueltos en chala y cocidos al vapor. Son diferentes a los de otras provincias por sus condimentos únicos y la técnica de cierre. Se venden en los mercados artesanales de San Salvador de Jujuy y Salta.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (68, 16, 'Vino Torrontés Salteño', 'Vino blanco aromático de altura elaborado en los Valles Calchaquíes a más de 1700 metros sobre el nivel del mar. Es considerado uno de los mejores vinos blancos de América del Sur. Su aroma intenso a rosas y frutas tropicales es inconfundible.', 'Bebida', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (69, 17, 'Empanadas Sanjuaninas', 'Empanadas con relleno de carne, cebolla, ají y aceitunas, con un toque de comino característico de la región cuyana. Se hornean en horno de barro y tienen una masa fina y dorada. Son infaltables en las festividades de la Fiesta Nacional del Sol.', 'Entrada', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (70, 17, 'Chanfaina', 'Guiso de vísceras de cordero o cabrito con papas, cebolla y condimentos tradicionales. Es un plato de aprovechamiento de raíz española muy arraigado en la cocina rural sanjuanina. Su sabor intenso y contundente lo hace ideal para los días fríos de la precordillera.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (71, 17, 'Arrope de Uva', 'Dulce concentrado elaborado cociendo el mosto de uva hasta reducirlo a una consistencia espesa y oscura. Es una tradición vitícola sanjuanina que data de la época colonial. Se usa como endulzante natural, para untar en pan o como base de postres regionales.', 'Postre', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (72, 17, 'Vino de San Juan', 'Vinos elaborados con uvas Syrah, Cabernet Sauvignon y Malbec en el oasis vitícola sanjuanino. La provincia es la segunda mayor productora de vinos de Argentina después de Mendoza. Su clima árido y soleado produce uvas de alta concentración de azúcar y color.', 'Bebida', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (73, 18, 'Cabrito al Horno', 'Cabrito joven criado en las sierras puntanas, marinado con hierbas locales y cocinado lentamente en horno de barro. Es el plato más representativo de la gastronomía serrana de San Luis. Su carne tierna y de sabor delicado es muy apreciada en toda la región cuyana.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (74, 18, 'Empanadas Puntanas', 'Empanadas de masa fina con relleno de carne vacuna, cebolla y condimentos, fritas en grasa o aceite. Tienen características propias que las diferencian de las empanadas de otras provincias cuyanas. Se venden en los festivales folklóricos de la provincia.', 'Entrada', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (75, 18, 'Arroz con Leche Serrano', 'Postre cremoso elaborado con arroz, leche de cabra de las sierras, azúcar y canela. La leche de cabra le da un sabor y cremosidad únicos al tradicional postre. Es una especialidad de las queseras artesanales de las sierras puntanas.', 'Postre', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (76, 18, 'Queso de Cabra Puntano', 'Queso artesanal elaborado con leche de cabras criadas en las sierras de San Luis. Tiene diferentes variedades: fresco, semicurado y curado, cada uno con características propias. Es el producto gastronómico más exportado de la provincia y reconocido a nivel nacional.', 'Entrada', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (77, 19, 'Cordero Santacruceño', 'Cordero criado en la estepa patagónica de Santa Cruz, considerado el de mejor calidad en Argentina por su alimentación natural. Se prepara al asador o al horno de barro con hierbas patagónicas. Su carne magra y de sabor profundo es exportada a los mejores restaurantes del mundo.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (78, 19, 'Centolla del Estrecho', 'Centolla capturada en las frías aguas del Estrecho de Magallanes, cocida al vapor y servida con salsa golf o limón. Es el marisco más valioso de Santa Cruz y uno de los más apreciados del mundo. Su carne blanca y dulce es un manjar reservado para las grandes ocasiones.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (79, 19, 'Guanaco Estofado', 'Estofado elaborado con carne de guanaco, camélido nativo de la Patagonia, con verduras y vino tinto. Es uno de los platos más exóticos y representativos de la cocina patagónica profunda. La carne de guanaco es magra, roja y de sabor similar al venado.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (80, 19, 'Calafate Sour', 'Cóctel elaborado con el licor del calafate, fruto silvestre patagónico de color azul intenso. Según la leyenda mapuche, quien come calafate regresa siempre a la Patagonia. Tiene un sabor agridulce y un color morado vibrante que lo hace muy atractivo visualmente.', 'Bebida', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (81, 20, 'Revuelto Gramajo', 'Plato de papas fritas en juliana salteadas con jamón, huevos y verduras. Fue creado en Buenos Aires pero adoptado como clásico de la cocina rosarina y santafesina. Es un plato de las confiterías y bares tradicionales de la ciudad de Rosario.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (82, 20, 'Surubí Rosarino', 'Surubí del río Paraná preparado a la parrilla, al horno o en escabeche, según las recetas tradicionales santafesinas. Rosario, ciudad portuaria sobre el Paraná, tiene una larga tradición de cocina fluvial. Los restaurantes de la costanera son famosos por sus platos de pescado.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (83, 20, 'Chipá Rosarino', 'Versión santafesina del chipá guaraní, con influencia de la inmigración italiana en la forma de preparación. Es un producto artesanal muy popular en los mercados y ferias de la región. La presencia guaraní histórica en el litoral santafesino dejó su huella en la gastronomía local.', 'Snack', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (84, 20, 'Facturas Santafesinas', 'Medialunas, vigilantes, cañoncitos y otros productos de panadería con influencia de la inmigración italiana y española. Santa Fe tiene una tradición panadera muy fuerte gracias a las colectividades europeas que se asentaron en la región. Se consumen en los tradicionales cafés del centro de Rosario.', 'Entrada', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (85, 21, 'Locro Santiagueño', 'Locro elaborado con maíz blanco, porotos, zapallo, carne de cerdo y charqui, con un sabor más especiado que otras versiones. Es el plato más tradicional de Santiago del Estero, considerada la provincia más antigua de Argentina. Se cocina en ollas de barro sobre fogón de leña.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (86, 21, 'Empanadas Santiagueñas', 'Empanadas con relleno de carne condimentada con comino, ají y cebolla, fritas en grasa y con un sabor picante característico. Son reconocidas como las más sabrosas del norte argentino por los amantes de las empanadas. Se venden en puestos callejeros de toda la provincia.', 'Entrada', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (87, 21, 'Charqui', 'Carne vacuna deshidratada al sol y sal, técnica de conservación prehispánica adoptada por los criollos santiagueños. Es ingrediente fundamental del locro y otros guisos de la región. Su sabor concentrado e intenso aporta profundidad a los platos tradicionales.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (88, 21, 'Aloja de Maíz', 'Bebida fermentada ancestral elaborada con maíz, agua y azúcar de caña. Es una bebida ceremonial y cotidiana de los pueblos originarios de Santiago del Estero. Tiene un sabor levemente ácido y burbujeante con bajo contenido alcohólico.', 'Bebida', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (89, 22, 'Centolla Fueguina', 'Centolla del Canal Beagle y el Atlántico sur fueguino, cocida al vapor o gratinada al horno con manteca y hierbas. Es el producto gastronómico más famoso de Tierra del Fuego, exportado a los mejores restaurantes del mundo. Su captura está regulada para preservar la especie.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (90, 22, 'Cordero Fueguino', 'Cordero criado en los campos ventosos de Tierra del Fuego, con una carne de sabor único por su alimentación en pasturas naturales subantárticas. Se prepara al asador o en cazuela con hierbas locales. Es el plato principal de los estancieros fueguinos.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (91, 22, 'Trucha de Ushuaia', 'Truchas criadas en los ríos y lagos del Parque Nacional Tierra del Fuego, preparadas ahumadas o a la manteca. El ahumado artesanal con leña de lenga, árbol nativo fueguino, le da un sabor y aroma únicos. Son consideradas las mejores truchas ahumadas de Argentina.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (92, 22, 'Calafate Helado', 'Helado artesanal elaborado con el fruto del calafate, arbusto nativo de la Patagonia austral. Tiene un color azul intenso y un sabor agridulce y aromático muy particular. Es el souvenir gastronómico más buscado por los turistas que visitan Ushuaia.', 'Postre', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (93, 23, 'Empanadas Tucumanas', 'Las empanadas más famosas de Argentina, rellenas de carne de pollo o vacuna con papa, huevo duro y cebolla de verdeo. Se hornean en horno de barro y se comen con la mano, sorbiendo el jugo que contienen. Tucumán es la capital nacional de la empanada.', 'Entrada', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (94, 23, 'Locro Tucumano', 'Locro con maíz blanco, porotos, mondongo, carne de cerdo y chorizo colorado, con condimentos únicos de la cocina tucumana. Es el plato obligatorio del 25 de mayo en toda la provincia. Su preparación es un evento social que reúne a familias y comunidades enteras.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (95, 23, 'Dulce de Cayote', 'Dulce artesanal elaborado con cayote, variedad de zapallo nativo de Tucumán, cocido con azúcar y nueces. Es un postre tradicional tucumano que se sirve con queso fresco. Su textura fibrosa y transparente lo hace único entre los dulces regionales argentinos.', 'Postre', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (96, 23, 'Café Tucumano', 'El café en Tucumán tiene una cultura propia, con los tradicionales cafés céntricos donde se debate política y se hace negocios. La provincia tiene una importante producción de azúcar que endulza el café tucumano. Los "cortados" y "lágrimas" son los pedidos más populares en los bares del centro.', 'Bebida', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (97, 24, 'Asado Porteño', 'Asado urbano preparado en los patios y terrazas de Buenos Aires con cortes de carne vacuna, chorizos y morcillas. La cultura del asado en Buenos Aires tiene su propia liturgia y protocolo. El asador porteño es una figura respetada en toda reunión social.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (98, 24, 'Pizza a la Piedra Porteña', 'Pizza de masa fina y crocante cocida directamente sobre la piedra del horno, con abundante queso y poco tomate. Buenos Aires tiene una de las tradiciones pizzeras más importantes del mundo gracias a la inmigración italiana. Las pizzerías del centro porteño son instituciones centenarias.', 'Plato principal', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (99, 24, 'Medialunas de Manteca', 'Medialunas elaboradas con manteca, con una textura hojaldrada y un glaseado dulce brillante característico. Son el desayuno porteño por excelencia, consumidas en los bares y confiterías de la ciudad. Cada barrio tiene su confitería de culto con sus propias medialunas legendarias.', 'Entrada', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');
INSERT INTO public.gastronomia VALUES (100, 24, 'Submarino', 'Bebida caliente consistente en leche caliente con una barra de chocolate que se sumerge y derrite lentamente. Es un clásico de los bares y confiterías porteñas, especialmente popular en invierno. La combinación de leche caliente y chocolate amargo es el consuelo porteño por excelencia.', 'Bebida', NULL, '2026-06-16 00:28:38', '2026-06-16 00:28:38');


--
-- TOC entry 6131 (class 0 OID 28692)
-- Dependencies: 241
-- Data for Name: imagenes_resenas; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.imagenes_resenas VALUES (2, 7, 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=400', '2026-06-15 00:24:24', '2026-06-15 00:24:24');


--
-- TOC entry 6133 (class 0 OID 28699)
-- Dependencies: 243
-- Data for Name: job_batches; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 6134 (class 0 OID 28711)
-- Dependencies: 244
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 6136 (class 0 OID 28723)
-- Dependencies: 246
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.migrations VALUES (1, '0001_01_01_000000_create_users_table', 1);
INSERT INTO public.migrations VALUES (2, '0001_01_01_000001_create_cache_table', 1);
INSERT INTO public.migrations VALUES (3, '0001_01_01_000002_create_jobs_table', 1);
INSERT INTO public.migrations VALUES (4, '2026_06_06_000001_create_roles_table', 1);
INSERT INTO public.migrations VALUES (5, '2026_06_06_000002_create_permisos_table', 1);
INSERT INTO public.migrations VALUES (6, '2026_06_06_000003_create_provincias_table', 1);
INSERT INTO public.migrations VALUES (7, '2026_06_06_000004_create_destinos_table', 1);
INSERT INTO public.migrations VALUES (8, '2026_06_06_000005_create_eventos_table', 1);
INSERT INTO public.migrations VALUES (9, '2026_06_06_000006_create_gastronomia_table', 1);
INSERT INTO public.migrations VALUES (10, '2026_06_06_000007_create_resenas_table', 1);
INSERT INTO public.migrations VALUES (11, '2026_06_06_000008_create_imagenes_resenas_table', 1);
INSERT INTO public.migrations VALUES (12, '2026_06_06_000009_create_favoritos_table', 1);
INSERT INTO public.migrations VALUES (13, '2026_06_06_000010_create_destinos_visitados_table', 1);
INSERT INTO public.migrations VALUES (14, '2026_06_06_000011_create_configuraciones_table', 1);
INSERT INTO public.migrations VALUES (15, '2026_06_06_000012_create_role_user_table', 1);
INSERT INTO public.migrations VALUES (16, '2026_06_06_000013_create_role_permiso_table', 1);
INSERT INTO public.migrations VALUES (17, '2026_06_13_161801_add_descripcion_to_eventos_table', 2);
INSERT INTO public.migrations VALUES (18, '2026_06_15_143246_create_provincia_imagenes_table', 2);
INSERT INTO public.migrations VALUES (19, '2026_06_15_234157_create_evento_favoritos_table', 2);
INSERT INTO public.migrations VALUES (20, '2026_06_15_234158_create_evento_visitados_table', 2);


--
-- TOC entry 6138 (class 0 OID 28730)
-- Dependencies: 248
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 6139 (class 0 OID 28737)
-- Dependencies: 249
-- Data for Name: permisos; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.permisos VALUES (1, 'crear_destino', 'Permiso para crear nuevos destinos turísticos', '2026-06-12 13:58:02', '2026-06-12 13:58:02');
INSERT INTO public.permisos VALUES (2, 'eliminar_comentario', 'Permiso para moderar y borrar comentarios/reseñas', '2026-06-12 13:58:02', '2026-06-12 13:58:02');
INSERT INTO public.permisos VALUES (3, 'modificar_destino', 'Permiso para editar información de destinos existentes', '2026-06-15 00:24:23', '2026-06-15 00:24:23');
INSERT INTO public.permisos VALUES (4, 'eliminar_destino', 'Permiso para dar de baja destinos del sistema', '2026-06-15 00:24:23', '2026-06-15 00:24:23');
INSERT INTO public.permisos VALUES (5, 'administrar_destinos_sugeridos', 'Permiso para moderar y aprobar destinos enviados por usuarios', '2026-06-15 00:24:23', '2026-06-15 00:24:23');
INSERT INTO public.permisos VALUES (6, 'crear_evento', 'Permiso para dar de alta nuevos eventos o festivales', '2026-06-15 00:24:23', '2026-06-15 00:24:23');
INSERT INTO public.permisos VALUES (7, 'modificar_evento', 'Permiso para editar fechas y datos de los eventos', '2026-06-15 00:24:23', '2026-06-15 00:24:23');
INSERT INTO public.permisos VALUES (8, 'eliminar_evento', 'Permiso para remover eventos de la agenda', '2026-06-15 00:24:23', '2026-06-15 00:24:23');
INSERT INTO public.permisos VALUES (9, 'administrar_eventos_sugeridos', 'Permiso para gestionar las propuestas de eventos comunitarios', '2026-06-15 00:24:23', '2026-06-15 00:24:23');
INSERT INTO public.permisos VALUES (11, 'gestionar_gastronomia', 'Permiso para administrar los puntos gastronómicos y menúes recomendados', '2026-06-15 00:24:23', '2026-06-15 00:24:23');
INSERT INTO public.permisos VALUES (10, 'administrar_resenas', 'Permiso para moderar, reportar o borrar comentarios de la comunidad', '2026-06-15 00:24:23', '2026-06-15 00:24:23');


--
-- TOC entry 6155 (class 0 OID 28986)
-- Dependencies: 265
-- Data for Name: provincia_imagenes; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 6141 (class 0 OID 28745)
-- Dependencies: 251
-- Data for Name: provincias; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.provincias VALUES (1, 'Buenos Aires', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (2, 'Catamarca', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (3, 'Chaco', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (4, 'Chubut', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (5, 'Córdoba', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (6, 'Corrientes', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (7, 'Entre Ríos', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (8, 'Formosa', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (9, 'Jujuy', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (10, 'La Pampa', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (11, 'La Rioja', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (12, 'Mendoza', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (13, 'Misiones', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (14, 'Neuquén', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (15, 'Río Negro', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (16, 'Salta', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (17, 'San Juan', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (18, 'San Luis', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (19, 'Santa Cruz', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (20, 'Santa Fe', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (21, 'Santiago del Estero', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (22, 'Tierra del Fuego', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (23, 'Tucumán', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');
INSERT INTO public.provincias VALUES (24, 'Ciudad Autónoma de Buenos Aires', NULL, NULL, NULL, '2026-06-12 11:07:09', '2026-06-12 11:07:09');


--
-- TOC entry 6143 (class 0 OID 28753)
-- Dependencies: 253
-- Data for Name: resenas; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.resenas VALUES (5, 3, 76, NULL, 5, NULL, 'klfjwjfo4ifjjh4ou', false, true, '2026-06-12 16:42:17', '2026-06-12 16:42:17');
INSERT INTO public.resenas VALUES (6, 3, 84, NULL, 3, NULL, 'tfvygbhj', false, true, '2026-06-12 18:32:17', '2026-06-12 18:32:17');
INSERT INTO public.resenas VALUES (4, 3, 76, NULL, 3, NULL, 'f342hye4fdh2', false, false, '2026-06-12 16:41:29', '2026-06-13 17:40:25');
INSERT INTO public.resenas VALUES (7, 2, 89, NULL, 5, 'Increíble viaje en verano', '¡San Martín de los Andes es hermoso! La Ruta de los Siete Lagos es un recorrido obligatorio. Todo impecable, un aire super puro y los chocolates increíbles.', false, true, '2026-06-15 00:24:24', '2026-06-15 00:24:24');
INSERT INTO public.resenas VALUES (8, 2, 84, NULL, 4, 'Buenas bodegas y paisajes únicos', 'Muy buenas bodegas y paisajes. Recomiendo alquilar bici para recorrer la zona de bodegas y probar las empanadas salteñas en el centro de Cafayate.', false, true, '2026-06-15 00:24:24', '2026-06-15 00:24:24');
INSERT INTO public.resenas VALUES (9, 2, NULL, 5, 5, 'Ideal para golosos', '¡Increíble la barra de chocolate gigante que hacen en la calle Mitre! Muy familiar y divertido.', false, true, '2026-06-15 00:24:24', '2026-06-15 00:24:24');


--
-- TOC entry 6145 (class 0 OID 28767)
-- Dependencies: 255
-- Data for Name: role_permiso; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.role_permiso VALUES (1, 1, 1, NULL, NULL);
INSERT INTO public.role_permiso VALUES (2, 1, 2, NULL, NULL);
INSERT INTO public.role_permiso VALUES (4, 1, 3, NULL, NULL);
INSERT INTO public.role_permiso VALUES (5, 1, 4, NULL, NULL);
INSERT INTO public.role_permiso VALUES (6, 1, 5, NULL, NULL);
INSERT INTO public.role_permiso VALUES (7, 1, 6, NULL, NULL);
INSERT INTO public.role_permiso VALUES (8, 1, 7, NULL, NULL);
INSERT INTO public.role_permiso VALUES (9, 1, 8, NULL, NULL);
INSERT INTO public.role_permiso VALUES (10, 1, 9, NULL, NULL);
INSERT INTO public.role_permiso VALUES (11, 1, 10, NULL, NULL);
INSERT INTO public.role_permiso VALUES (12, 1, 11, NULL, NULL);
INSERT INTO public.role_permiso VALUES (13, 3, 6, NULL, NULL);
INSERT INTO public.role_permiso VALUES (14, 3, 7, NULL, NULL);
INSERT INTO public.role_permiso VALUES (15, 3, 8, NULL, NULL);
INSERT INTO public.role_permiso VALUES (16, 3, 9, NULL, NULL);
INSERT INTO public.role_permiso VALUES (17, 4, 1, NULL, NULL);
INSERT INTO public.role_permiso VALUES (18, 4, 3, NULL, NULL);
INSERT INTO public.role_permiso VALUES (19, 4, 4, NULL, NULL);
INSERT INTO public.role_permiso VALUES (20, 4, 5, NULL, NULL);
INSERT INTO public.role_permiso VALUES (21, 4, 10, NULL, NULL);


--
-- TOC entry 6147 (class 0 OID 28774)
-- Dependencies: 257
-- Data for Name: role_user; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.role_user VALUES (1, 1, 1, NULL, NULL);
INSERT INTO public.role_user VALUES (2, 2, 2, NULL, NULL);
INSERT INTO public.role_user VALUES (4, 3, 3, NULL, NULL);
INSERT INTO public.role_user VALUES (6, 4, 4, NULL, NULL);
INSERT INTO public.role_user VALUES (7, 5, 2, NULL, NULL);
INSERT INTO public.role_user VALUES (8, 6, 2, NULL, NULL);


--
-- TOC entry 6149 (class 0 OID 28781)
-- Dependencies: 259
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.roles VALUES (1, 'Admin', 'Administrador total de la plataforma', '2026-06-12 13:58:02', '2026-06-12 13:58:02');
INSERT INTO public.roles VALUES (2, 'Turista', 'Usuario turista que explora y reseña destinos', '2026-06-12 13:58:02', '2026-06-12 13:58:02');
INSERT INTO public.roles VALUES (3, 'AdministradorFestivales', 'Puede crear nuevos festivales, modificar o eliminar festivales existentes, también puede aceptar o rechazar festivales sugeridos por los usuarios.', '2026-06-12 14:51:27', '2026-06-12 14:51:27');
INSERT INTO public.roles VALUES (4, 'Conductor', 'Rol creado unicamente para Tulio', '2026-06-15 03:01:23', '2026-06-15 03:01:23');


--
-- TOC entry 6151 (class 0 OID 28789)
-- Dependencies: 261
-- Data for Name: sessions; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.sessions VALUES ('vs2KodMHYf416a5LGTWYIdFqoNFxt9qobOm1iqoz', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Safari/537.36', 'eyJfdG9rZW4iOiJNS3F5Y1QxejUzSEN0WGo1R05jTW9icTVMbXNrNlVIVjVhaUZZZVoyIiwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvMTI3LjAuMC4xOjgwMDAiLCJyb3V0ZSI6ImhvbWUifX0=', 1781583223);


--
-- TOC entry 5836 (class 0 OID 27840)
-- Dependencies: 221
-- Data for Name: spatial_ref_sys; Type: TABLE DATA; Schema: public; Owner: -
--



--
-- TOC entry 6152 (class 0 OID 28797)
-- Dependencies: 262
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: -
--

INSERT INTO public.users VALUES (2, 'Juan Viajero', 'turista@example.com', NULL, '$2y$12$5UP9gtRSzbGcip3LA3XydeIRIrb93zp/p/GUNAv/WsTbxcsgv7D5y', NULL, 'https://api.dicebear.com/7.x/adventurer/svg?seed=Juan', 'Amante de la Patagonia, la gastronomía andina y del buen folklore.', NULL, '2026-06-12 13:58:04', '2026-06-12 13:58:04');
INSERT INTO public.users VALUES (1, 'Admin Surify', 'admin@surify.com', '2026-06-12 11:48:50', '$2y$12$2bm9MycYzvlm4yi7T5IqV.lQ6Vrjv0cAWBI3kzuOFYi/ecDbsEl3K', NULL, '/storage/avatars/WJw9QaQQZ5XcD2AsvDDskl3IV553IDoKNTFytTOc.png', 'Creador y administrador de Surify.', NULL, '2026-06-12 13:58:04', '2026-06-12 14:13:10');
INSERT INTO public.users VALUES (3, 'Juan Carlos Bodoque', 'paw@gmail.com', '2026-06-14 22:00:00', '$2y$12$6HUKEwUbGHT4otJjgBH6AerewWGJd.xMzhZBveufMmw7cpRLoexI2', NULL, '/storage/avatars/YQvIqZ8l2KHHbbeqLcmWTa9h2ewpQSy5uWbxC4so.png', NULL, NULL, '2026-06-12 14:29:09', '2026-06-12 14:29:50');
INSERT INTO public.users VALUES (4, 'Tulio Triviño', '31minutos@gmail.com', '2026-06-14 22:00:00', '$2y$12$5QaVuh5SYHaVxrWW0I8PXe0xzGJMXILDI1l8sWXd5pdv2jc8l62vS', NULL, '/storage/avatars/Flkh6AHp2gNB0Bi1CU59QRxdLUwKJSuHYYuUUFBz.png', NULL, NULL, '2026-06-15 02:56:49', '2026-06-15 02:59:47');
INSERT INTO public.users VALUES (5, 'Juanin Juan Harry', 'juanin@gmail.com', '2026-06-12 11:48:50', '$2y$12$6dv65kzro4IvXwgEyAT.huMm7CXd2TK1C3B3f1M6QBAShkyWcbPUS', NULL, '/storage/avatars/hR8UiuxB4NMClBWeLcGyOiIQri25Qjp7IqSmNnnH.jpg', NULL, NULL, '2026-06-15 16:54:58', '2026-06-15 16:56:43');
INSERT INTO public.users VALUES (6, 'Surify Contacto', 'surifycontacto@gmail.com', NULL, NULL, '106340904650267433646', 'https://lh3.googleusercontent.com/a/ACg8ocJBWi9dxg5vo7gr_T7nkwgoSuKCxZGbvF5eSYHhwXLp5M0dSqg=s96-c', NULL, NULL, '2026-06-16 03:29:20', '2026-06-16 03:29:20');


--
-- TOC entry 6186 (class 0 OID 0)
-- Dependencies: 228
-- Name: configuraciones_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.configuraciones_id_seq', 1, false);


--
-- TOC entry 6187 (class 0 OID 0)
-- Dependencies: 230
-- Name: destinos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.destinos_id_seq', 90, true);


--
-- TOC entry 6188 (class 0 OID 0)
-- Dependencies: 232
-- Name: destinos_visitados_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.destinos_visitados_id_seq', 2, true);


--
-- TOC entry 6189 (class 0 OID 0)
-- Dependencies: 266
-- Name: evento_favoritos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.evento_favoritos_id_seq', 1, false);


--
-- TOC entry 6190 (class 0 OID 0)
-- Dependencies: 268
-- Name: evento_visitados_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.evento_visitados_id_seq', 1, false);


--
-- TOC entry 6191 (class 0 OID 0)
-- Dependencies: 234
-- Name: eventos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.eventos_id_seq', 6, true);


--
-- TOC entry 6192 (class 0 OID 0)
-- Dependencies: 236
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 1, false);


--
-- TOC entry 6193 (class 0 OID 0)
-- Dependencies: 238
-- Name: favoritos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.favoritos_id_seq', 4, true);


--
-- TOC entry 6194 (class 0 OID 0)
-- Dependencies: 240
-- Name: gastronomia_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.gastronomia_id_seq', 100, true);


--
-- TOC entry 6195 (class 0 OID 0)
-- Dependencies: 242
-- Name: imagenes_resenas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.imagenes_resenas_id_seq', 2, true);


--
-- TOC entry 6196 (class 0 OID 0)
-- Dependencies: 245
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.jobs_id_seq', 1, false);


--
-- TOC entry 6197 (class 0 OID 0)
-- Dependencies: 247
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.migrations_id_seq', 20, true);


--
-- TOC entry 6198 (class 0 OID 0)
-- Dependencies: 250
-- Name: permisos_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.permisos_id_seq', 11, true);


--
-- TOC entry 6199 (class 0 OID 0)
-- Dependencies: 264
-- Name: provincia_imagenes_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.provincia_imagenes_id_seq', 1, false);


--
-- TOC entry 6200 (class 0 OID 0)
-- Dependencies: 252
-- Name: provincias_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.provincias_id_seq', 41, true);


--
-- TOC entry 6201 (class 0 OID 0)
-- Dependencies: 254
-- Name: resenas_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.resenas_id_seq', 9, true);


--
-- TOC entry 6202 (class 0 OID 0)
-- Dependencies: 256
-- Name: role_permiso_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.role_permiso_id_seq', 21, true);


--
-- TOC entry 6203 (class 0 OID 0)
-- Dependencies: 258
-- Name: role_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.role_user_id_seq', 8, true);


--
-- TOC entry 6204 (class 0 OID 0)
-- Dependencies: 260
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.roles_id_seq', 4, true);


--
-- TOC entry 6205 (class 0 OID 0)
-- Dependencies: 263
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: -
--

SELECT pg_catalog.setval('public.users_id_seq', 6, true);


--
-- TOC entry 5871 (class 2606 OID 28824)
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- TOC entry 5868 (class 2606 OID 28826)
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- TOC entry 5873 (class 2606 OID 28828)
-- Name: configuraciones configuraciones_clave_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.configuraciones
    ADD CONSTRAINT configuraciones_clave_unique UNIQUE (clave);


--
-- TOC entry 5875 (class 2606 OID 28830)
-- Name: configuraciones configuraciones_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.configuraciones
    ADD CONSTRAINT configuraciones_pkey PRIMARY KEY (id);


--
-- TOC entry 5877 (class 2606 OID 28832)
-- Name: destinos destinos_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.destinos
    ADD CONSTRAINT destinos_pkey PRIMARY KEY (id);


--
-- TOC entry 5879 (class 2606 OID 28834)
-- Name: destinos_visitados destinos_visitados_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.destinos_visitados
    ADD CONSTRAINT destinos_visitados_pkey PRIMARY KEY (id);


--
-- TOC entry 5933 (class 2606 OID 29013)
-- Name: evento_favoritos evento_favoritos_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evento_favoritos
    ADD CONSTRAINT evento_favoritos_pkey PRIMARY KEY (id);


--
-- TOC entry 5935 (class 2606 OID 29025)
-- Name: evento_favoritos evento_favoritos_user_id_evento_id_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evento_favoritos
    ADD CONSTRAINT evento_favoritos_user_id_evento_id_unique UNIQUE (user_id, evento_id);


--
-- TOC entry 5937 (class 2606 OID 29035)
-- Name: evento_visitados evento_visitados_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evento_visitados
    ADD CONSTRAINT evento_visitados_pkey PRIMARY KEY (id);


--
-- TOC entry 5939 (class 2606 OID 29047)
-- Name: evento_visitados evento_visitados_user_id_evento_id_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evento_visitados
    ADD CONSTRAINT evento_visitados_user_id_evento_id_unique UNIQUE (user_id, evento_id);


--
-- TOC entry 5881 (class 2606 OID 28836)
-- Name: eventos eventos_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.eventos
    ADD CONSTRAINT eventos_pkey PRIMARY KEY (id);


--
-- TOC entry 5884 (class 2606 OID 28838)
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 5886 (class 2606 OID 28840)
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- TOC entry 5888 (class 2606 OID 28842)
-- Name: favoritos favoritos_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.favoritos
    ADD CONSTRAINT favoritos_pkey PRIMARY KEY (id);


--
-- TOC entry 5890 (class 2606 OID 28844)
-- Name: gastronomia gastronomia_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.gastronomia
    ADD CONSTRAINT gastronomia_pkey PRIMARY KEY (id);


--
-- TOC entry 5892 (class 2606 OID 28846)
-- Name: imagenes_resenas imagenes_resenas_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.imagenes_resenas
    ADD CONSTRAINT imagenes_resenas_pkey PRIMARY KEY (id);


--
-- TOC entry 5894 (class 2606 OID 28848)
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- TOC entry 5896 (class 2606 OID 28850)
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- TOC entry 5899 (class 2606 OID 28852)
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- TOC entry 5901 (class 2606 OID 28854)
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- TOC entry 5903 (class 2606 OID 28856)
-- Name: permisos permisos_nombre_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.permisos
    ADD CONSTRAINT permisos_nombre_unique UNIQUE (nombre);


--
-- TOC entry 5905 (class 2606 OID 28858)
-- Name: permisos permisos_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.permisos
    ADD CONSTRAINT permisos_pkey PRIMARY KEY (id);


--
-- TOC entry 5931 (class 2606 OID 28998)
-- Name: provincia_imagenes provincia_imagenes_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.provincia_imagenes
    ADD CONSTRAINT provincia_imagenes_pkey PRIMARY KEY (id);


--
-- TOC entry 5907 (class 2606 OID 28860)
-- Name: provincias provincias_nombre_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.provincias
    ADD CONSTRAINT provincias_nombre_unique UNIQUE (nombre);


--
-- TOC entry 5909 (class 2606 OID 28862)
-- Name: provincias provincias_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.provincias
    ADD CONSTRAINT provincias_pkey PRIMARY KEY (id);


--
-- TOC entry 5911 (class 2606 OID 28864)
-- Name: resenas resenas_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.resenas
    ADD CONSTRAINT resenas_pkey PRIMARY KEY (id);


--
-- TOC entry 5913 (class 2606 OID 28866)
-- Name: role_permiso role_permiso_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.role_permiso
    ADD CONSTRAINT role_permiso_pkey PRIMARY KEY (id);


--
-- TOC entry 5915 (class 2606 OID 28868)
-- Name: role_user role_user_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.role_user
    ADD CONSTRAINT role_user_pkey PRIMARY KEY (id);


--
-- TOC entry 5917 (class 2606 OID 28870)
-- Name: roles roles_nombre_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_nombre_unique UNIQUE (nombre);


--
-- TOC entry 5919 (class 2606 OID 28872)
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- TOC entry 5922 (class 2606 OID 28874)
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- TOC entry 5925 (class 2606 OID 28876)
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- TOC entry 5927 (class 2606 OID 28878)
-- Name: users users_google_id_unique; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_google_id_unique UNIQUE (google_id);


--
-- TOC entry 5929 (class 2606 OID 28880)
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- TOC entry 5866 (class 1259 OID 28881)
-- Name: cache_expiration_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cache_expiration_index ON public.cache USING btree (expiration);


--
-- TOC entry 5869 (class 1259 OID 28882)
-- Name: cache_locks_expiration_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX cache_locks_expiration_index ON public.cache_locks USING btree (expiration);


--
-- TOC entry 5882 (class 1259 OID 28883)
-- Name: failed_jobs_connection_queue_failed_at_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX failed_jobs_connection_queue_failed_at_index ON public.failed_jobs USING btree (connection, queue, failed_at);


--
-- TOC entry 5897 (class 1259 OID 28884)
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- TOC entry 5920 (class 1259 OID 28885)
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- TOC entry 5923 (class 1259 OID 28886)
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: -
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- TOC entry 5940 (class 2606 OID 28887)
-- Name: destinos destinos_provincia_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.destinos
    ADD CONSTRAINT destinos_provincia_id_foreign FOREIGN KEY (provincia_id) REFERENCES public.provincias(id) ON DELETE CASCADE;


--
-- TOC entry 5941 (class 2606 OID 28892)
-- Name: destinos_visitados destinos_visitados_destino_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.destinos_visitados
    ADD CONSTRAINT destinos_visitados_destino_id_foreign FOREIGN KEY (destino_id) REFERENCES public.destinos(id) ON DELETE CASCADE;


--
-- TOC entry 5942 (class 2606 OID 28897)
-- Name: destinos_visitados destinos_visitados_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.destinos_visitados
    ADD CONSTRAINT destinos_visitados_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 5959 (class 2606 OID 29019)
-- Name: evento_favoritos evento_favoritos_evento_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evento_favoritos
    ADD CONSTRAINT evento_favoritos_evento_id_foreign FOREIGN KEY (evento_id) REFERENCES public.eventos(id) ON DELETE CASCADE;


--
-- TOC entry 5960 (class 2606 OID 29014)
-- Name: evento_favoritos evento_favoritos_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evento_favoritos
    ADD CONSTRAINT evento_favoritos_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 5961 (class 2606 OID 29041)
-- Name: evento_visitados evento_visitados_evento_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evento_visitados
    ADD CONSTRAINT evento_visitados_evento_id_foreign FOREIGN KEY (evento_id) REFERENCES public.eventos(id) ON DELETE CASCADE;


--
-- TOC entry 5962 (class 2606 OID 29036)
-- Name: evento_visitados evento_visitados_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.evento_visitados
    ADD CONSTRAINT evento_visitados_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 5943 (class 2606 OID 28902)
-- Name: eventos eventos_destino_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.eventos
    ADD CONSTRAINT eventos_destino_id_foreign FOREIGN KEY (destino_id) REFERENCES public.destinos(id) ON DELETE CASCADE;


--
-- TOC entry 5944 (class 2606 OID 28907)
-- Name: eventos eventos_provincia_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.eventos
    ADD CONSTRAINT eventos_provincia_id_foreign FOREIGN KEY (provincia_id) REFERENCES public.provincias(id) ON DELETE CASCADE;


--
-- TOC entry 5945 (class 2606 OID 28980)
-- Name: eventos eventos_sugerido_por_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.eventos
    ADD CONSTRAINT eventos_sugerido_por_foreign FOREIGN KEY (sugerido_por) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- TOC entry 5946 (class 2606 OID 28912)
-- Name: favoritos favoritos_destino_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.favoritos
    ADD CONSTRAINT favoritos_destino_id_foreign FOREIGN KEY (destino_id) REFERENCES public.destinos(id) ON DELETE CASCADE;


--
-- TOC entry 5947 (class 2606 OID 28917)
-- Name: favoritos favoritos_evento_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.favoritos
    ADD CONSTRAINT favoritos_evento_id_foreign FOREIGN KEY (evento_id) REFERENCES public.eventos(id) ON DELETE CASCADE;


--
-- TOC entry 5948 (class 2606 OID 28922)
-- Name: favoritos favoritos_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.favoritos
    ADD CONSTRAINT favoritos_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 5949 (class 2606 OID 28927)
-- Name: gastronomia gastronomia_provincia_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.gastronomia
    ADD CONSTRAINT gastronomia_provincia_id_foreign FOREIGN KEY (provincia_id) REFERENCES public.provincias(id) ON DELETE CASCADE;


--
-- TOC entry 5950 (class 2606 OID 28932)
-- Name: imagenes_resenas imagenes_resenas_resena_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.imagenes_resenas
    ADD CONSTRAINT imagenes_resenas_resena_id_foreign FOREIGN KEY (resena_id) REFERENCES public.resenas(id) ON DELETE CASCADE;


--
-- TOC entry 5958 (class 2606 OID 28999)
-- Name: provincia_imagenes provincia_imagenes_provincia_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.provincia_imagenes
    ADD CONSTRAINT provincia_imagenes_provincia_id_foreign FOREIGN KEY (provincia_id) REFERENCES public.provincias(id) ON DELETE CASCADE;


--
-- TOC entry 5951 (class 2606 OID 28937)
-- Name: resenas resenas_destino_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.resenas
    ADD CONSTRAINT resenas_destino_id_foreign FOREIGN KEY (destino_id) REFERENCES public.destinos(id) ON DELETE CASCADE;


--
-- TOC entry 5952 (class 2606 OID 28942)
-- Name: resenas resenas_evento_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.resenas
    ADD CONSTRAINT resenas_evento_id_foreign FOREIGN KEY (evento_id) REFERENCES public.eventos(id) ON DELETE CASCADE;


--
-- TOC entry 5953 (class 2606 OID 28947)
-- Name: resenas resenas_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.resenas
    ADD CONSTRAINT resenas_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


--
-- TOC entry 5954 (class 2606 OID 28952)
-- Name: role_permiso role_permiso_permiso_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.role_permiso
    ADD CONSTRAINT role_permiso_permiso_id_foreign FOREIGN KEY (permiso_id) REFERENCES public.permisos(id) ON DELETE CASCADE;


--
-- TOC entry 5955 (class 2606 OID 28957)
-- Name: role_permiso role_permiso_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.role_permiso
    ADD CONSTRAINT role_permiso_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- TOC entry 5956 (class 2606 OID 28962)
-- Name: role_user role_user_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.role_user
    ADD CONSTRAINT role_user_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- TOC entry 5957 (class 2606 OID 28967)
-- Name: role_user role_user_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: -
--

ALTER TABLE ONLY public.role_user
    ADD CONSTRAINT role_user_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE CASCADE;


-- Completed on 2026-06-16 01:59:09

--
-- PostgreSQL database dump complete
--


