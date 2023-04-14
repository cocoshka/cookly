ALTER TABLE public.user_data
  DROP CONSTRAINT user_data_fk_user;

ALTER TABLE public.user_data
  DROP CONSTRAINT user_data_fk_role;

ALTER TABLE public.role_permission
  DROP CONSTRAINT role_permission_fk_role;

ALTER TABLE public.role_permission
  DROP CONSTRAINT role_permission_fk_permission;

ALTER TABLE public.recipe
  DROP CONSTRAINT recipe_fk_user;

ALTER TABLE public.recipe_stars
  DROP CONSTRAINT recipe_stars_fk_user;

ALTER TABLE public.recipe_stars
  DROP CONSTRAINT recipe_stars_fk_recipe;

ALTER TABLE public.user_data
  ADD CONSTRAINT user_data_fk_user FOREIGN KEY (user_id)
    REFERENCES public."user" (id) MATCH SIMPLE
    ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE public.user_data
  ADD CONSTRAINT user_data_fk_role FOREIGN KEY (role_id)
    REFERENCES public.role (id) MATCH SIMPLE
    ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE public.role_permission
  ADD CONSTRAINT role_permission_fk_role FOREIGN KEY (role_id)
    REFERENCES public.role (id) MATCH SIMPLE
    ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE public.role_permission
  ADD CONSTRAINT role_permission_fk_permission FOREIGN KEY (permission_id)
    REFERENCES public.permission (id) MATCH SIMPLE
    ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE public.recipe
  ADD CONSTRAINT recipe_fk_user FOREIGN KEY (user_id)
    REFERENCES public."user" (id) MATCH SIMPLE
    ON DELETE SET NULL ON UPDATE CASCADE;

ALTER TABLE public.recipe_stars
  ADD CONSTRAINT recipe_stars_fk_user FOREIGN KEY (user_id)
    REFERENCES public."user" (id) MATCH SIMPLE
    ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE public.recipe_stars
  ADD CONSTRAINT recipe_stars_fk_recipe FOREIGN KEY (recipe_id)
    REFERENCES public.recipe (id) MATCH SIMPLE
    ON DELETE CASCADE ON UPDATE CASCADE;
