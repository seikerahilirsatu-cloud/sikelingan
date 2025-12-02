import React from 'react'
import { createRoot } from 'react-dom/client'

function Icon({ variant }) {
  switch (variant) {
    case 'info':
      return (
        <div className="w-12 h-12 grid place-items-center rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 text-white shadow ring-1 ring-white/30">
          <svg className="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 2a10 10 0 1 0 0 20a10 10 0 0 0 0-20Z" strokeWidth="2" /><path d="M12 8v8" strokeWidth="2" strokeLinecap="round" /><circle cx="12" cy="6" r="1.5" fill="currentColor" /></svg>
        </div>
      )
    case 'admin':
      return (
        <div className="w-12 h-12 grid place-items-center rounded-2xl bg-gradient-to-br from-green-500 to-emerald-600 text-white shadow ring-1 ring-white/30">
          <svg className="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="7" y="8" width="10" height="10" rx="2" strokeWidth="2" /><rect x="9" y="5" width="6" height="3" rx="1" strokeWidth="2" /><path d="M9 11h6M9 14h6" strokeWidth="2" strokeLinecap="round" /></svg>
        </div>
      )
    case 'complaint':
      return (
        <div className="w-12 h-12 grid place-items-center rounded-2xl bg-gradient-to-br from-rose-500 to-red-600 text-white shadow ring-1 ring-white/30">
          <svg className="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 4l8 14H4L12 4z" strokeWidth="2" strokeLinejoin="round" /><path d="M12 10v4" strokeWidth="2" strokeLinecap="round" /><circle cx="12" cy="16.5" r="1.2" fill="currentColor" /></svg>
        </div>
      )
    case 'contact':
      return (
        <div className="w-12 h-12 grid place-items-center rounded-2xl bg-gradient-to-br from-violet-500 to-fuchsia-600 text-white shadow ring-1 ring-white/30">
          <svg className="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M5 5h14v10a2 2 0 0 1-2 2H9l-4 3V7a2 2 0 0 1 2-2z" strokeWidth="2" strokeLinejoin="round" /></svg>
        </div>
      )
    case 'agenda':
      return (
        <div className="w-12 h-12 grid place-items-center rounded-2xl bg-gradient-to-br from-orange-500 to-amber-600 text-white shadow ring-1 ring-white/30">
          <svg className="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="5" y="7" width="14" height="11" rx="2" strokeWidth="2" /><path d="M8 4v4M16 4v4M5 11h14" strokeWidth="2" strokeLinecap="round" /></svg>
        </div>
      )
    case 'notice':
      return (
        <div className="w-12 h-12 grid place-items-center rounded-2xl bg-gradient-to-br from-teal-500 to-cyan-600 text-white shadow ring-1 ring-white/30">
          <svg className="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 5a5 5 0 0 1 5 5v4l1 2H6l1-2v-4a5 5 0 0 1 5-5z" strokeWidth="2" strokeLinejoin="round" /><circle cx="12" cy="19" r="1.8" fill="currentColor" /></svg>
        </div>
      )
    default:
      return null
  }
}

function Card({ label, icon }) {
  return (
    <a href="#" className="w-1/3 bg-white border border-gray-100 rounded-xl shadow-sm p-3 flex flex-col items-center justify-center gap-2 min-h-[96px] hover:shadow-md hover:-translate-y-0.5 transition-all">
      <Icon variant={icon} />
      <div className="mt-1 text-xs font-medium">{label}</div>
    </a>
  )
}

function Home() {
  return (
    <section className="space-y-6">
      <div className="rounded-2xl shadow p-6 bg-gradient-to-b from-blue-600 to-indigo-600 text-white">
        <div className="text-sm opacity-90">Selamat Datang di Kelurahan Sei Kera Hilir I</div>
        <div className="text-xl font-semibold mt-1">Layanan administrasi dan informasi Kelurahan</div>
      </div>
      <div className="flex flex-wrap gap-4">
        <Card label="Info Kelurahan" icon="info" />
        <Card label="Layanan Administrasi" icon="admin" />
        <Card label="Pengaduan" icon="complaint" />
        <Card label="Kontak" icon="contact" />
        <Card label="Agenda Kegiatan" icon="agenda" />
        <Card label="Informasi Penting" icon="notice" />
      </div>
    </section>
  )
}

const el = document.getElementById('root')
if (el) {
  createRoot(el).render(<Home />)
}

