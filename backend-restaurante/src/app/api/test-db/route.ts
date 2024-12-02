import { NextRequest, NextResponse } from 'next/server';
import pool from '@/lib/db';

export async function GET(req: NextRequest) {
    try {
        const [rows] = await pool.query('SELECT 1 + 1 AS solution');
        return NextResponse.json({ success: true, solution: rows[0].solution });
    } catch (error) {
        console.error(error);
        return NextResponse.json({ success: false, message: 'Database connection failed' }, { status: 500 });
    }
}

