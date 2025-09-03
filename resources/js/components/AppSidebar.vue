<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
//Iconos
import { BookOpen, Folder, LayoutGrid, Weight , UsersRound, Contact, ShoppingBasket, 
    BookUser, MapPinHouse, Store     } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

//Menu Lateral
const mainNavItems: NavItem[] = [
    //dashboar inicial
    {
        title: 'Dashboard',
        href: '/dashboard',
        icon: LayoutGrid,
    },
    
    //productos
    {
        title: 'Productos',
        href: '/Producto',
        icon: ShoppingBasket, // o cualquier otro ícono de lucide-vue-next
    },

    //proveedores
    {
        title: 'Proveedores',
        href: '/Proveedor',//route('proveedor.index'), // 👈 referencia por nombre
        icon: Contact, // o cualquier otro ícono de lucide-vue-next
    },
    
    //usuarios
    {
    title: 'Usuarios',
    href: '/User', // 👈 Usando nombre de ruta -- el nombre de la ruta en routes es el que se usara xd 
    icon: UsersRound,
    },

    // Categorías
    {
    title: 'Categorías',
    href: '/Categoria',
    icon: LayoutGrid, // 👈 Representa categorías / grillas
    },

    // Subcategorias
    {
        title: 'Subcategoria',
        href: '/Subcategoria',
        icon: LayoutGrid, // 👈 Representa categorías / grillas
    },

    // Roles
    {
        title: 'Roles',
        href: '/Rol',
        icon: BookUser, //
    },

    // Unidad Medida
    {
        title: 'Tipo Medidas',
        href: '/Unidadmedida',
        icon: Weight, //
    },

    // Sucursal
    {
        title: 'Sucursales',
        href: '/Sucursal',
        icon: MapPinHouse , //
    },

    // Bodega
    {
        title: 'Bodega',
        href: '/Bodega',
        icon: Store  , //
    },

];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
