export interface User {
  id: number;
  name: string;
  email: string;
  email_verified_at: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  auth: {
    settings?: {
      id: number;
      start1: string;
      end1: string;
      start2: string;
      end2: string;
      start3: string;
      end3: string;
      BINANCE_API_KEY: string;
      BINANCE_API_SECRET: string;
    };
    user: User;
    is_admin: boolean;
    roles: Array<{
      id: number;
      name: string;
    }>;
  };
  impersonate: {
    id: number;
  };
};
