CREATE VIEW public.user_view
AS
SELECT u.id,
       u.email,
       ud.name,
       ud.avatar,
       ud.role_id,
       r.name AS role_name
FROM public."user" as u
       JOIN public.user_data AS ud ON u.id = ud.user_id
       JOIN public.role AS r ON ud.role_id = r.id;
