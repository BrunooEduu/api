CREATE TABLE public.usuario (
	usucodigo int4 NOT NULL,
	usunome varchar(50) NOT NULL,
	usuemail varchar(60) NULL,
	ususenha varchar(200) NULL,
	cd_grupo int4 NOT NULL DEFAULT 1,
	usutoken varchar(200) NULL,
	usuativo int2 NOT NULL DEFAULT 1,
	CONSTRAINT usuario_pkey PRIMARY KEY (usucodigo)
);