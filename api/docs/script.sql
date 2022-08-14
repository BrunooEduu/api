CREATE TABLE public.usuario (
	usucodigo int4 NOT NULL,
	usunome varchar(50) NOT NULL,
	usuemail varchar(60) NULL,
	ususenha varchar(200) NULL,
	usutoken varchar(200) NULL,
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