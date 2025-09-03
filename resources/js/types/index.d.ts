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
    Apellido: string;
    email: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
    foto_perfil?: string; // ← Agregar este campo
    profile_image_url: string | null; // ← Este ya lo tienes
}


export type BreadcrumbItemType = BreadcrumbItem;

// Datos que se cargan del Modelo, para Mostrar en la tabla
export interface Proveedor {
    Idproveedor: number;
    Razon_social: string;
    Telefono: string;
    Direccion: string;
    Correo: string | null;
    created_at: string;
    updated_at: string;
}

// Datos que se cargan del Modelo, para Mostrar en la tabla
export interface Unidadmedida {
    Id_Medida: number;
    Nombre_Medida: string;
    created_at?: string;
    updated_at?: string;
}

// Datos que se cargan del Modelo, para Mostrar en la tabla
export interface Categoria {
    Idcategoria: number;          // PK
    Nombre_cat: string | null;
    created_at: string | null;
    updated_at: string | null;

    subcategorias?: Subcategoria[];
}

// Datos que se cargan del Modelo, para Mostrar en la tabla
export interface Subcategoria {
    Idsubcat: number;              // PK
    Idcategoria: number;           // FK a categorias
    Nombre_subcat: string;
    created_at: string | null;
    updated_at: string | null;

    // Relaciones opcionales
    categoria?: Categoria;
    productos?: Producto[];
}

// Datos que se cargan del Modelo, para Mostrar en la tabla
export interface Producto {
    Idproducto: number;
    Idsubcat: number;
    Id_Medida: number;
    Codigo_barra: string;
    Nombre: string;
    foto: string;
    Precio_costo: number;
    Precio_venta: number;
    Precio_descuento: number;
    Precio_Mayorista: number;
    Estado: string;
    created_at: string;
    updated_at: string;

    subcategoria?: Subcategoria;   // relación cargada
    unidadmedida?: Unidadmedida;   // relación cargada
}

// Datos que se cargan del Modelo, para Mostrar en la tabla
export interface Rol {
    Idrol: number;
    nombre: string;
    descripcion: string;
}

// Datos que se cargan del Modelo, para Mostrar en la tabla
export interface Sucursal {
    Idsucursal: number;
    Nombre_Sucursal: string;
    Direccion: string;
    Gerente: string;
    created_at?: string;
    updated_at?: string;
}

// Datos que se cargan del Modelo, para Mostrar en la tabla
export interface Bodega {
    Idbodega: number;
    Nombre_bodega: string;
    Direccion: string;
    Idsucursal: number;
    created_at?: string;
    updated_at?: string;

    sucursal?: Sucursal;
}
