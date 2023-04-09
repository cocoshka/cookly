CREATE TABLE public."user"
(
  id       serial       NOT NULL,
  email    varchar(254) NOT NULL,
  password text         NOT NULL,
  CONSTRAINT user_pk PRIMARY KEY (id),
  CONSTRAINT user_uq_email UNIQUE (email)
);

CREATE TABLE public.role
(
  id         serial       NOT NULL,
  name       varchar(256) NOT NULL,
  is_default bool,
  CONSTRAINT role_pk PRIMARY KEY (id),
  CONSTRAINT role_uq_is_default UNIQUE (is_default)
);

CREATE TABLE public.user_data
(
  user_id integer      NOT NULL,
  role_id integer      NOT NULL,
  name    varchar(256) NOT NULL,
  avatar  bytea,
  CONSTRAINT user_data_pk PRIMARY KEY (user_id)
);

CREATE TABLE public.permission
(
  id   serial NOT NULL,
  name text   NOT NULL,
  CONSTRAINT permission_pk PRIMARY KEY (id),
  CONSTRAINT permission_uq_name UNIQUE (name)
);

CREATE TABLE public.role_permission
(
  role_id       integer NOT NULL,
  permission_id integer NOT NULL,
  CONSTRAINT role_permission_pk PRIMARY KEY (role_id, permission_id)
);

CREATE TABLE public.recipe
(
  id        serial       NOT NULL,
  user_id   integer      NOT NULL,
  name      varchar(256) NOT NULL,
  image     bytea        NOT NULL,
  details   text         NOT NULL,
  is_public bool,
  CONSTRAINT recipe_pk PRIMARY KEY (id)
);

CREATE TABLE public.recipe_stars
(
  recipe_id integer NOT NULL,
  user_id   integer NOT NULL,
  rating    integer NOT NULL,
  CONSTRAINT recipe_stars_pk PRIMARY KEY (recipe_id, user_id)
);

CREATE INDEX recipe_stars_ix_recipe_id ON public.recipe_stars (recipe_id);

ALTER TABLE public.user_data
  ADD CONSTRAINT user_data_fk_user FOREIGN KEY (user_id)
    REFERENCES public."user" (id) MATCH SIMPLE
    ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE public.user_data
  ADD CONSTRAINT user_data_fk_role FOREIGN KEY (role_id)
    REFERENCES public.role (id) MATCH SIMPLE
    ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE public.role_permission
  ADD CONSTRAINT role_permission_fk_role FOREIGN KEY (role_id)
    REFERENCES public.role (id) MATCH SIMPLE
    ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE public.role_permission
  ADD CONSTRAINT role_permission_fk_permission FOREIGN KEY (permission_id)
    REFERENCES public.permission (id) MATCH SIMPLE
    ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE public.recipe
  ADD CONSTRAINT recipe_fk_user FOREIGN KEY (user_id)
    REFERENCES public."user" (id) MATCH SIMPLE
    ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE public.recipe_stars
  ADD CONSTRAINT recipe_stars_fk_user FOREIGN KEY (user_id)
    REFERENCES public."user" (id) MATCH SIMPLE
    ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE public.recipe_stars
  ADD CONSTRAINT recipe_stars_fk_recipe FOREIGN KEY (recipe_id)
    REFERENCES public.recipe (id) MATCH SIMPLE
    ON DELETE NO ACTION ON UPDATE NO ACTION;
