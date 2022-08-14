CREATE TABLE public.usuario (
	usucodigo serial NOT NULL,
	usunome varchar(50) NOT NULL,
	usuemail varchar(60) not NULL,
	ususenha varchar(200) not NULL,
	usutoken text NULL,
	usuativo int2 NOT NULL DEFAULT 1,
	CONSTRAINT usuario_pkey PRIMARY KEY (usucodigo)
);

CREATE TABLE public.auxilioemergencial (
	id serial NOT NULL,
	codigoibge INT NOT NULL,
	mesano INT NOT NULL,
	pagina  INT NOT NULL,
	dados jsonb not null default '{}'
	CONSTRAINT auxilioemergencial_pkey PRIMARY KEY (id)
);

CREATE TABLE public.atividade (
	id serial NOT NULL,
	data INT NOT NULL,
	status varchar(100) default 'status_not_verified',
	atividade text,
	CONSTRAINT atividade_pkey PRIMARY KEY (id)
);

CREATE TABLE public.feedback (
	id serial NOT NULL,
	usucodigo INT NOT NULL,
	idatividade INT NOT NULL,
	feedback text null,
	CONSTRAINT feedback_pkey PRIMARY KEY (id),
	CONSTRAINT feedback_usuario_fkey FOREIGN KEY (usucodigo) REFERENCES public.usuario(usucodigo),
	CONSTRAINT feedback_atividade_fkey FOREIGN KEY (idatividade) REFERENCES public.atividade(id)
);