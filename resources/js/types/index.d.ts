import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface User {
    Idusuario: number;
    name: string;
    Apellido:string,
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;

//Datos que se cargan del Modelo, para Mostrar en la tabla
export interface Proveedor {
    Idproveedor: number;
    Razon_social:string;
    Telefono:string;
    Direccion:string;
    Correo:string | null;
    created_at: string;
    updated_at: string;
}

//Datos que se cargan del Modelo, para Mostrar en la tabla
export interface Producto {
    Idproducto: any;
    id: number;
    Idsubcat: number;
    Id_Medida: number;
    Codigo_barra: string;
    Nombre:string
    foto:string
    Precio_costo:number;
    Precio_venta:number;
    Precio_descuento:number;
    Precio_Mayorista:number;
    Estado:string;
    created_at: string;
    updated_at: string;
    subcategoria?: Subcategoria; // relación cargada
    unidadmedida?:Unidadmedida
}

//Datos que se cargan del Modelo, para Mostrar en la tabla
export interface Categoria {
    id: number;
    Nombre_cat: string;
}

//Datos que se cargan del Modelo, para Mostrar en la tabla
export interface Subcategoria {
    id: number;
    Nombre_subcat: string;
    Idcategoria: number;
    categoria?:Categoria;
}

//Datos que se cargan del Modelo, para Mostrar en la tabla
export interface Unidadmedida {
    id: number;
    Nombre_Medida: string;
}

