--
-- PostgreSQL database dump
--

\restrict HKq1XuhJ72M3Yzm4iHnxGMKBBFf0YVXKkxdlbt9HajT3RrwWF2Ypg9fU9nTaWg5

-- Dumped from database version 14.19 (Ubuntu 14.19-0ubuntu0.22.04.1)
-- Dumped by pg_dump version 14.19 (Ubuntu 14.19-0ubuntu0.22.04.1)

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

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: academic_levels; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.academic_levels (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    code character varying(255) NOT NULL,
    description text,
    duration_years integer NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.academic_levels OWNER TO omen;

--
-- Name: academic_levels_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.academic_levels_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.academic_levels_id_seq OWNER TO omen;

--
-- Name: academic_levels_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.academic_levels_id_seq OWNED BY public.academic_levels.id;


--
-- Name: academic_years; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.academic_years (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    start_date date NOT NULL,
    end_date date NOT NULL,
    is_current boolean DEFAULT false NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.academic_years OWNER TO omen;

--
-- Name: academic_years_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.academic_years_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.academic_years_id_seq OWNER TO omen;

--
-- Name: academic_years_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.academic_years_id_seq OWNED BY public.academic_years.id;


--
-- Name: attendances; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.attendances (
    id bigint NOT NULL,
    student_id bigint NOT NULL,
    class_id bigint NOT NULL,
    subject_id bigint,
    date date NOT NULL,
    status character varying(255) DEFAULT 'present'::character varying NOT NULL,
    reason text,
    is_justified boolean DEFAULT false NOT NULL,
    marked_by bigint NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT attendances_status_check CHECK (((status)::text = ANY ((ARRAY['present'::character varying, 'absent'::character varying, 'late'::character varying, 'excused'::character varying])::text[])))
);


ALTER TABLE public.attendances OWNER TO omen;

--
-- Name: attendances_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.attendances_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.attendances_id_seq OWNER TO omen;

--
-- Name: attendances_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.attendances_id_seq OWNED BY public.attendances.id;


--
-- Name: cache; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.cache (
    key character varying(255) NOT NULL,
    value text NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache OWNER TO omen;

--
-- Name: cache_locks; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.cache_locks (
    key character varying(255) NOT NULL,
    owner character varying(255) NOT NULL,
    expiration integer NOT NULL
);


ALTER TABLE public.cache_locks OWNER TO omen;

--
-- Name: classes; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.classes (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    code character varying(255) NOT NULL,
    academic_level_id bigint NOT NULL,
    capacity integer DEFAULT 40 NOT NULL,
    school_fees numeric(10,2) DEFAULT '0'::numeric NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.classes OWNER TO omen;

--
-- Name: classes_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.classes_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.classes_id_seq OWNER TO omen;

--
-- Name: classes_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.classes_id_seq OWNED BY public.classes.id;


--
-- Name: enrollments; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.enrollments (
    id bigint NOT NULL,
    student_id bigint NOT NULL,
    class_id bigint NOT NULL,
    academic_year_id bigint NOT NULL,
    enrollment_date date NOT NULL,
    fees_paid numeric(10,2) DEFAULT '0'::numeric NOT NULL,
    fees_due numeric(10,2) DEFAULT '0'::numeric NOT NULL,
    status character varying(255) DEFAULT 'active'::character varying NOT NULL,
    notes text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT enrollments_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'completed'::character varying, 'transferred'::character varying, 'dropped'::character varying])::text[])))
);


ALTER TABLE public.enrollments OWNER TO omen;

--
-- Name: enrollments_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.enrollments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.enrollments_id_seq OWNER TO omen;

--
-- Name: enrollments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.enrollments_id_seq OWNED BY public.enrollments.id;


--
-- Name: evaluations; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.evaluations (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    subject_id bigint NOT NULL,
    class_id bigint NOT NULL,
    academic_year_id bigint NOT NULL,
    teacher_id bigint NOT NULL,
    type character varying(255) NOT NULL,
    date date NOT NULL,
    max_score numeric(5,2) DEFAULT '20'::numeric NOT NULL,
    duration_minutes integer,
    description text,
    status character varying(255) DEFAULT 'draft'::character varying NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT evaluations_status_check CHECK (((status)::text = ANY ((ARRAY['draft'::character varying, 'published'::character varying, 'completed'::character varying])::text[]))),
    CONSTRAINT evaluations_type_check CHECK (((type)::text = ANY ((ARRAY['quiz'::character varying, 'test'::character varying, 'exam'::character varying, 'assignment'::character varying])::text[])))
);


ALTER TABLE public.evaluations OWNER TO omen;

--
-- Name: evaluations_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.evaluations_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.evaluations_id_seq OWNER TO omen;

--
-- Name: evaluations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.evaluations_id_seq OWNED BY public.evaluations.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: omen
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


ALTER TABLE public.failed_jobs OWNER TO omen;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.failed_jobs_id_seq OWNER TO omen;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: grades; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.grades (
    id bigint NOT NULL,
    student_id bigint NOT NULL,
    evaluation_id bigint NOT NULL,
    score numeric(5,2) NOT NULL,
    feedback text,
    graded_at timestamp(0) without time zone,
    graded_by bigint,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.grades OWNER TO omen;

--
-- Name: grades_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.grades_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.grades_id_seq OWNER TO omen;

--
-- Name: grades_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.grades_id_seq OWNED BY public.grades.id;


--
-- Name: job_batches; Type: TABLE; Schema: public; Owner: omen
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


ALTER TABLE public.job_batches OWNER TO omen;

--
-- Name: jobs; Type: TABLE; Schema: public; Owner: omen
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


ALTER TABLE public.jobs OWNER TO omen;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.jobs_id_seq OWNER TO omen;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO omen;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.migrations_id_seq OWNER TO omen;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: model_has_permissions; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.model_has_permissions (
    permission_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);


ALTER TABLE public.model_has_permissions OWNER TO omen;

--
-- Name: model_has_roles; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.model_has_roles (
    role_id bigint NOT NULL,
    model_type character varying(255) NOT NULL,
    model_id bigint NOT NULL
);


ALTER TABLE public.model_has_roles OWNER TO omen;

--
-- Name: parents; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.parents (
    id bigint NOT NULL,
    first_name character varying(255) NOT NULL,
    last_name character varying(255) NOT NULL,
    relationship character varying(255) NOT NULL,
    phone character varying(255) NOT NULL,
    phone_2 character varying(255),
    email character varying(255),
    profession character varying(255),
    address text NOT NULL,
    is_emergency_contact boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT parents_relationship_check CHECK (((relationship)::text = ANY ((ARRAY['father'::character varying, 'mother'::character varying, 'guardian'::character varying, 'other'::character varying])::text[])))
);


ALTER TABLE public.parents OWNER TO omen;

--
-- Name: parents_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.parents_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.parents_id_seq OWNER TO omen;

--
-- Name: parents_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.parents_id_seq OWNED BY public.parents.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO omen;

--
-- Name: permissions; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.permissions (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.permissions OWNER TO omen;

--
-- Name: permissions_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.permissions_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.permissions_id_seq OWNER TO omen;

--
-- Name: permissions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.permissions_id_seq OWNED BY public.permissions.id;


--
-- Name: personal_access_tokens; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.personal_access_tokens (
    id bigint NOT NULL,
    tokenable_type character varying(255) NOT NULL,
    tokenable_id bigint NOT NULL,
    name text NOT NULL,
    token character varying(64) NOT NULL,
    abilities text,
    last_used_at timestamp(0) without time zone,
    expires_at timestamp(0) without time zone,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.personal_access_tokens OWNER TO omen;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.personal_access_tokens_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.personal_access_tokens_id_seq OWNER TO omen;

--
-- Name: personal_access_tokens_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.personal_access_tokens_id_seq OWNED BY public.personal_access_tokens.id;


--
-- Name: role_has_permissions; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.role_has_permissions (
    permission_id bigint NOT NULL,
    role_id bigint NOT NULL
);


ALTER TABLE public.role_has_permissions OWNER TO omen;

--
-- Name: roles; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.roles (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    guard_name character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.roles OWNER TO omen;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.roles_id_seq OWNER TO omen;

--
-- Name: roles_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.roles_id_seq OWNED BY public.roles.id;


--
-- Name: sessions; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.sessions (
    id character varying(255) NOT NULL,
    user_id bigint,
    ip_address character varying(45),
    user_agent text,
    payload text NOT NULL,
    last_activity integer NOT NULL
);


ALTER TABLE public.sessions OWNER TO omen;

--
-- Name: student_parent; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.student_parent (
    id bigint NOT NULL,
    student_id bigint NOT NULL,
    parent_id bigint NOT NULL,
    is_primary_contact boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.student_parent OWNER TO omen;

--
-- Name: student_parent_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.student_parent_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.student_parent_id_seq OWNER TO omen;

--
-- Name: student_parent_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.student_parent_id_seq OWNED BY public.student_parent.id;


--
-- Name: students; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.students (
    id bigint NOT NULL,
    student_number character varying(255) NOT NULL,
    first_name character varying(255) NOT NULL,
    last_name character varying(255) NOT NULL,
    birth_date date NOT NULL,
    birth_place character varying(255) NOT NULL,
    gender character varying(255) NOT NULL,
    nationality character varying(255) DEFAULT 'Ivoirienne'::character varying NOT NULL,
    phone character varying(255),
    email character varying(255),
    address text NOT NULL,
    photo character varying(255),
    enrollment_date date NOT NULL,
    status character varying(255) DEFAULT 'active'::character varying NOT NULL,
    medical_info text,
    notes text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT students_gender_check CHECK (((gender)::text = ANY ((ARRAY['M'::character varying, 'F'::character varying])::text[]))),
    CONSTRAINT students_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'suspended'::character varying, 'graduated'::character varying, 'dropped'::character varying])::text[])))
);


ALTER TABLE public.students OWNER TO omen;

--
-- Name: students_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.students_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.students_id_seq OWNER TO omen;

--
-- Name: students_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.students_id_seq OWNED BY public.students.id;


--
-- Name: subjects; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.subjects (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    code character varying(255) NOT NULL,
    description text,
    coefficient integer DEFAULT 1 NOT NULL,
    color character varying(7) DEFAULT '#3490dc'::character varying NOT NULL,
    is_active boolean DEFAULT true NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.subjects OWNER TO omen;

--
-- Name: subjects_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.subjects_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.subjects_id_seq OWNER TO omen;

--
-- Name: subjects_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.subjects_id_seq OWNED BY public.subjects.id;


--
-- Name: teacher_class_assignments; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.teacher_class_assignments (
    id bigint NOT NULL,
    teacher_id bigint NOT NULL,
    class_id bigint NOT NULL,
    subject_id bigint NOT NULL,
    academic_year_id bigint NOT NULL,
    is_main_teacher boolean DEFAULT false NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone
);


ALTER TABLE public.teacher_class_assignments OWNER TO omen;

--
-- Name: teacher_class_assignments_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.teacher_class_assignments_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.teacher_class_assignments_id_seq OWNER TO omen;

--
-- Name: teacher_class_assignments_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.teacher_class_assignments_id_seq OWNED BY public.teacher_class_assignments.id;


--
-- Name: teachers; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.teachers (
    id bigint NOT NULL,
    teacher_number character varying(255) NOT NULL,
    first_name character varying(255) NOT NULL,
    last_name character varying(255) NOT NULL,
    birth_date date NOT NULL,
    gender character varying(255) NOT NULL,
    phone character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    address text NOT NULL,
    qualification character varying(255) NOT NULL,
    hire_date date NOT NULL,
    salary numeric(10,2),
    status character varying(255) DEFAULT 'active'::character varying NOT NULL,
    photo character varying(255),
    specializations text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    CONSTRAINT teachers_gender_check CHECK (((gender)::text = ANY ((ARRAY['M'::character varying, 'F'::character varying])::text[]))),
    CONSTRAINT teachers_status_check CHECK (((status)::text = ANY ((ARRAY['active'::character varying, 'inactive'::character varying, 'retired'::character varying])::text[])))
);


ALTER TABLE public.teachers OWNER TO omen;

--
-- Name: teachers_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.teachers_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.teachers_id_seq OWNER TO omen;

--
-- Name: teachers_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.teachers_id_seq OWNED BY public.teachers.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: omen
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    email_verified_at timestamp(0) without time zone,
    password character varying(255) NOT NULL,
    remember_token character varying(100),
    current_team_id bigint,
    profile_photo_path character varying(2048),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    two_factor_secret text,
    two_factor_recovery_codes text,
    two_factor_confirmed_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO omen;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: omen
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.users_id_seq OWNER TO omen;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: omen
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: academic_levels id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.academic_levels ALTER COLUMN id SET DEFAULT nextval('public.academic_levels_id_seq'::regclass);


--
-- Name: academic_years id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.academic_years ALTER COLUMN id SET DEFAULT nextval('public.academic_years_id_seq'::regclass);


--
-- Name: attendances id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.attendances ALTER COLUMN id SET DEFAULT nextval('public.attendances_id_seq'::regclass);


--
-- Name: classes id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.classes ALTER COLUMN id SET DEFAULT nextval('public.classes_id_seq'::regclass);


--
-- Name: enrollments id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.enrollments ALTER COLUMN id SET DEFAULT nextval('public.enrollments_id_seq'::regclass);


--
-- Name: evaluations id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.evaluations ALTER COLUMN id SET DEFAULT nextval('public.evaluations_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: grades id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.grades ALTER COLUMN id SET DEFAULT nextval('public.grades_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: parents id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.parents ALTER COLUMN id SET DEFAULT nextval('public.parents_id_seq'::regclass);


--
-- Name: permissions id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.permissions ALTER COLUMN id SET DEFAULT nextval('public.permissions_id_seq'::regclass);


--
-- Name: personal_access_tokens id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.personal_access_tokens ALTER COLUMN id SET DEFAULT nextval('public.personal_access_tokens_id_seq'::regclass);


--
-- Name: roles id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.roles ALTER COLUMN id SET DEFAULT nextval('public.roles_id_seq'::regclass);


--
-- Name: student_parent id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.student_parent ALTER COLUMN id SET DEFAULT nextval('public.student_parent_id_seq'::regclass);


--
-- Name: students id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.students ALTER COLUMN id SET DEFAULT nextval('public.students_id_seq'::regclass);


--
-- Name: subjects id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.subjects ALTER COLUMN id SET DEFAULT nextval('public.subjects_id_seq'::regclass);


--
-- Name: teacher_class_assignments id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.teacher_class_assignments ALTER COLUMN id SET DEFAULT nextval('public.teacher_class_assignments_id_seq'::regclass);


--
-- Name: teachers id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.teachers ALTER COLUMN id SET DEFAULT nextval('public.teachers_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Name: academic_levels academic_levels_code_unique; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.academic_levels
    ADD CONSTRAINT academic_levels_code_unique UNIQUE (code);


--
-- Name: academic_levels academic_levels_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.academic_levels
    ADD CONSTRAINT academic_levels_pkey PRIMARY KEY (id);


--
-- Name: academic_years academic_years_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.academic_years
    ADD CONSTRAINT academic_years_pkey PRIMARY KEY (id);


--
-- Name: attendances attendances_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.attendances
    ADD CONSTRAINT attendances_pkey PRIMARY KEY (id);


--
-- Name: cache_locks cache_locks_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.cache_locks
    ADD CONSTRAINT cache_locks_pkey PRIMARY KEY (key);


--
-- Name: cache cache_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.cache
    ADD CONSTRAINT cache_pkey PRIMARY KEY (key);


--
-- Name: classes classes_code_unique; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.classes
    ADD CONSTRAINT classes_code_unique UNIQUE (code);


--
-- Name: classes classes_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.classes
    ADD CONSTRAINT classes_pkey PRIMARY KEY (id);


--
-- Name: enrollments enrollments_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.enrollments
    ADD CONSTRAINT enrollments_pkey PRIMARY KEY (id);


--
-- Name: evaluations evaluations_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.evaluations
    ADD CONSTRAINT evaluations_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: grades grades_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.grades
    ADD CONSTRAINT grades_pkey PRIMARY KEY (id);


--
-- Name: grades grades_student_id_evaluation_id_unique; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.grades
    ADD CONSTRAINT grades_student_id_evaluation_id_unique UNIQUE (student_id, evaluation_id);


--
-- Name: job_batches job_batches_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.job_batches
    ADD CONSTRAINT job_batches_pkey PRIMARY KEY (id);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: model_has_permissions model_has_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_pkey PRIMARY KEY (permission_id, model_id, model_type);


--
-- Name: model_has_roles model_has_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_pkey PRIMARY KEY (role_id, model_id, model_type);


--
-- Name: parents parents_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.parents
    ADD CONSTRAINT parents_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: permissions permissions_name_guard_name_unique; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_name_guard_name_unique UNIQUE (name, guard_name);


--
-- Name: permissions permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.permissions
    ADD CONSTRAINT permissions_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_pkey PRIMARY KEY (id);


--
-- Name: personal_access_tokens personal_access_tokens_token_unique; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.personal_access_tokens
    ADD CONSTRAINT personal_access_tokens_token_unique UNIQUE (token);


--
-- Name: role_has_permissions role_has_permissions_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_pkey PRIMARY KEY (permission_id, role_id);


--
-- Name: roles roles_name_guard_name_unique; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_name_guard_name_unique UNIQUE (name, guard_name);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: sessions sessions_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.sessions
    ADD CONSTRAINT sessions_pkey PRIMARY KEY (id);


--
-- Name: student_parent student_parent_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.student_parent
    ADD CONSTRAINT student_parent_pkey PRIMARY KEY (id);


--
-- Name: students students_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.students
    ADD CONSTRAINT students_pkey PRIMARY KEY (id);


--
-- Name: students students_student_number_unique; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.students
    ADD CONSTRAINT students_student_number_unique UNIQUE (student_number);


--
-- Name: subjects subjects_code_unique; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.subjects
    ADD CONSTRAINT subjects_code_unique UNIQUE (code);


--
-- Name: subjects subjects_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.subjects
    ADD CONSTRAINT subjects_pkey PRIMARY KEY (id);


--
-- Name: teacher_class_assignments teacher_class_assignments_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.teacher_class_assignments
    ADD CONSTRAINT teacher_class_assignments_pkey PRIMARY KEY (id);


--
-- Name: teachers teachers_email_unique; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.teachers
    ADD CONSTRAINT teachers_email_unique UNIQUE (email);


--
-- Name: teachers teachers_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.teachers
    ADD CONSTRAINT teachers_pkey PRIMARY KEY (id);


--
-- Name: teachers teachers_teacher_number_unique; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.teachers
    ADD CONSTRAINT teachers_teacher_number_unique UNIQUE (teacher_number);


--
-- Name: attendances unique_attendance; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.attendances
    ADD CONSTRAINT unique_attendance UNIQUE (student_id, date, subject_id);


--
-- Name: enrollments unique_student_year; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.enrollments
    ADD CONSTRAINT unique_student_year UNIQUE (student_id, academic_year_id);


--
-- Name: teacher_class_assignments unique_teacher_assignment; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.teacher_class_assignments
    ADD CONSTRAINT unique_teacher_assignment UNIQUE (teacher_id, class_id, subject_id, academic_year_id);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: omen
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: model_has_permissions_model_id_model_type_index; Type: INDEX; Schema: public; Owner: omen
--

CREATE INDEX model_has_permissions_model_id_model_type_index ON public.model_has_permissions USING btree (model_id, model_type);


--
-- Name: model_has_roles_model_id_model_type_index; Type: INDEX; Schema: public; Owner: omen
--

CREATE INDEX model_has_roles_model_id_model_type_index ON public.model_has_roles USING btree (model_id, model_type);


--
-- Name: personal_access_tokens_expires_at_index; Type: INDEX; Schema: public; Owner: omen
--

CREATE INDEX personal_access_tokens_expires_at_index ON public.personal_access_tokens USING btree (expires_at);


--
-- Name: personal_access_tokens_tokenable_type_tokenable_id_index; Type: INDEX; Schema: public; Owner: omen
--

CREATE INDEX personal_access_tokens_tokenable_type_tokenable_id_index ON public.personal_access_tokens USING btree (tokenable_type, tokenable_id);


--
-- Name: sessions_last_activity_index; Type: INDEX; Schema: public; Owner: omen
--

CREATE INDEX sessions_last_activity_index ON public.sessions USING btree (last_activity);


--
-- Name: sessions_user_id_index; Type: INDEX; Schema: public; Owner: omen
--

CREATE INDEX sessions_user_id_index ON public.sessions USING btree (user_id);


--
-- Name: attendances attendances_class_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.attendances
    ADD CONSTRAINT attendances_class_id_foreign FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE CASCADE;


--
-- Name: attendances attendances_marked_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.attendances
    ADD CONSTRAINT attendances_marked_by_foreign FOREIGN KEY (marked_by) REFERENCES public.teachers(id);


--
-- Name: attendances attendances_student_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.attendances
    ADD CONSTRAINT attendances_student_id_foreign FOREIGN KEY (student_id) REFERENCES public.students(id) ON DELETE CASCADE;


--
-- Name: attendances attendances_subject_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.attendances
    ADD CONSTRAINT attendances_subject_id_foreign FOREIGN KEY (subject_id) REFERENCES public.subjects(id) ON DELETE CASCADE;


--
-- Name: classes classes_academic_level_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.classes
    ADD CONSTRAINT classes_academic_level_id_foreign FOREIGN KEY (academic_level_id) REFERENCES public.academic_levels(id) ON DELETE CASCADE;


--
-- Name: enrollments enrollments_academic_year_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.enrollments
    ADD CONSTRAINT enrollments_academic_year_id_foreign FOREIGN KEY (academic_year_id) REFERENCES public.academic_years(id) ON DELETE CASCADE;


--
-- Name: enrollments enrollments_class_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.enrollments
    ADD CONSTRAINT enrollments_class_id_foreign FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE CASCADE;


--
-- Name: enrollments enrollments_student_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.enrollments
    ADD CONSTRAINT enrollments_student_id_foreign FOREIGN KEY (student_id) REFERENCES public.students(id) ON DELETE CASCADE;


--
-- Name: evaluations evaluations_academic_year_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.evaluations
    ADD CONSTRAINT evaluations_academic_year_id_foreign FOREIGN KEY (academic_year_id) REFERENCES public.academic_years(id) ON DELETE CASCADE;


--
-- Name: evaluations evaluations_class_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.evaluations
    ADD CONSTRAINT evaluations_class_id_foreign FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE CASCADE;


--
-- Name: evaluations evaluations_subject_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.evaluations
    ADD CONSTRAINT evaluations_subject_id_foreign FOREIGN KEY (subject_id) REFERENCES public.subjects(id) ON DELETE CASCADE;


--
-- Name: evaluations evaluations_teacher_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.evaluations
    ADD CONSTRAINT evaluations_teacher_id_foreign FOREIGN KEY (teacher_id) REFERENCES public.teachers(id) ON DELETE CASCADE;


--
-- Name: grades grades_evaluation_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.grades
    ADD CONSTRAINT grades_evaluation_id_foreign FOREIGN KEY (evaluation_id) REFERENCES public.evaluations(id) ON DELETE CASCADE;


--
-- Name: grades grades_graded_by_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.grades
    ADD CONSTRAINT grades_graded_by_foreign FOREIGN KEY (graded_by) REFERENCES public.teachers(id);


--
-- Name: grades grades_student_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.grades
    ADD CONSTRAINT grades_student_id_foreign FOREIGN KEY (student_id) REFERENCES public.students(id) ON DELETE CASCADE;


--
-- Name: model_has_permissions model_has_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.model_has_permissions
    ADD CONSTRAINT model_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- Name: model_has_roles model_has_roles_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.model_has_roles
    ADD CONSTRAINT model_has_roles_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: role_has_permissions role_has_permissions_permission_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_permission_id_foreign FOREIGN KEY (permission_id) REFERENCES public.permissions(id) ON DELETE CASCADE;


--
-- Name: role_has_permissions role_has_permissions_role_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.role_has_permissions
    ADD CONSTRAINT role_has_permissions_role_id_foreign FOREIGN KEY (role_id) REFERENCES public.roles(id) ON DELETE CASCADE;


--
-- Name: student_parent student_parent_parent_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.student_parent
    ADD CONSTRAINT student_parent_parent_id_foreign FOREIGN KEY (parent_id) REFERENCES public.parents(id) ON DELETE CASCADE;


--
-- Name: student_parent student_parent_student_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.student_parent
    ADD CONSTRAINT student_parent_student_id_foreign FOREIGN KEY (student_id) REFERENCES public.students(id) ON DELETE CASCADE;


--
-- Name: teacher_class_assignments teacher_class_assignments_academic_year_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.teacher_class_assignments
    ADD CONSTRAINT teacher_class_assignments_academic_year_id_foreign FOREIGN KEY (academic_year_id) REFERENCES public.academic_years(id) ON DELETE CASCADE;


--
-- Name: teacher_class_assignments teacher_class_assignments_class_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.teacher_class_assignments
    ADD CONSTRAINT teacher_class_assignments_class_id_foreign FOREIGN KEY (class_id) REFERENCES public.classes(id) ON DELETE CASCADE;


--
-- Name: teacher_class_assignments teacher_class_assignments_subject_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.teacher_class_assignments
    ADD CONSTRAINT teacher_class_assignments_subject_id_foreign FOREIGN KEY (subject_id) REFERENCES public.subjects(id) ON DELETE CASCADE;


--
-- Name: teacher_class_assignments teacher_class_assignments_teacher_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: omen
--

ALTER TABLE ONLY public.teacher_class_assignments
    ADD CONSTRAINT teacher_class_assignments_teacher_id_foreign FOREIGN KEY (teacher_id) REFERENCES public.teachers(id) ON DELETE CASCADE;


--
-- PostgreSQL database dump complete
--

\unrestrict HKq1XuhJ72M3Yzm4iHnxGMKBBFf0YVXKkxdlbt9HajT3RrwWF2Ypg9fU9nTaWg5

