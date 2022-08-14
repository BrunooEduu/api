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